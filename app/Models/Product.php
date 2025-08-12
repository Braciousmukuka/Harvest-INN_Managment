<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'price',
        'price_unit',
        'quantity',
        'quantity_unit',
        'low_stock_threshold',
        'status',
        'image',
        'harvested_date',
        'expiry_date',
        'location',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harvested_date' => 'date',
        'expiry_date' => 'date',
        'price' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];

    /**
     * Boot method to add model event listeners
     */
    protected static function boot()
    {
        parent::boot();
        
        // Automatically update status based on quantity when saving
        static::saving(function ($product) {
            $product->updateStockStatus();
        });
    }

    /**
     * Update stock status based on quantity
     */
    public function updateStockStatus()
    {
        if ($this->quantity <= 0) {
            $this->status = 'out_of_stock';
        } elseif ($this->quantity < 20) {
            $this->status = 'low_stock';
        } elseif ($this->status !== 'in_stock' && $this->quantity >= 20) {
            $this->status = 'in_stock';
        }
    }

    /**
     * Check if product is low stock
     */
    public function isLowStock(): bool
    {
        return $this->quantity < 20 && $this->quantity > 0;
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Get stock status text
     */
    public function getStockStatusText(): string
    {
        if ($this->isOutOfStock()) {
            return 'Out of Stock';
        } elseif ($this->isLowStock()) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }
}
