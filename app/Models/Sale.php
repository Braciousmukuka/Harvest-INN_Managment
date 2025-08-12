<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_number',
        'product_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'quantity_sold',
        'quantity_unit',
        'unit_price',
        'total_amount',
        'discount_amount',
        'final_amount',
        'payment_method',
        'payment_status',
        'payment_reference',
        'sale_date',
        'notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_date' => 'date',
        'quantity_sold' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    /**
     * Boot method to add model event listeners
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($sale) {
            if (!$sale->sale_number) {
                $sale->sale_number = $sale->generateSaleNumber();
            }
            
            // Calculate final amount
            $sale->final_amount = $sale->total_amount - $sale->discount_amount;
        });

        static::updating(function ($sale) {
            // Recalculate final amount if total or discount changes
            if ($sale->isDirty(['total_amount', 'discount_amount'])) {
                $sale->final_amount = $sale->total_amount - $sale->discount_amount;
            }
        });
    }

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate unique sale number
     */
    private function generateSaleNumber()
    {
        $date = now()->format('Ymd');
        
        // Get the last sale number for today to determine the next sequence
        $lastSale = static::where('sale_number', 'like', 'SAL' . $date . '%')
                          ->orderBy('sale_number', 'desc')
                          ->first();
        
        if ($lastSale) {
            $sequence = (int)substr($lastSale->sale_number, -4) + 1;
        } else {
            $sequence = 1;
        }
        
        // Ensure uniqueness by checking if this number already exists
        do {
            $saleNumber = 'SAL' . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            $exists = static::where('sale_number', $saleNumber)->exists();
            if ($exists) {
                $sequence++;
            }
        } while ($exists);
        
        return $saleNumber;
    }

    /**
     * Get formatted sale number
     */
    public function getFormattedSaleNumberAttribute()
    {
        return strtoupper($this->sale_number);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'completed' => 'bg-success',
            'pending' => 'bg-warning',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            'completed' => 'bg-success',
            'pending' => 'bg-warning',
            'failed' => 'bg-danger',
            'refunded' => 'bg-info',
            default => 'bg-secondary'
        };
    }

    /**
     * Scope for completed sales
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for today's sales
     */
    public function scopeToday($query)
    {
        return $query->whereDate('sale_date', now());
    }

    /**
     * Scope for this month's sales
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('sale_date', now()->month)
                    ->whereYear('sale_date', now()->year);
    }
}
