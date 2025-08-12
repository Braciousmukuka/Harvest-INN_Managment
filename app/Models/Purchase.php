<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_number',
        'supplier_name',
        'supplier_contact',
        'supplier_email',
        'supplier_address',
        'item_name',
        'item_description',
        'category',
        'quantity',
        'quantity_unit',
        'unit_price',
        'total_amount',
        'purchase_date',
        'delivery_date',
        'status',
        'payment_status',
        'notes',
        'storage_location',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'delivery_date' => 'date',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Boot the model and generate purchase number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            if (empty($purchase->purchase_number)) {
                $purchase->purchase_number = 'PUR-' . date('Y') . '-' . str_pad(Purchase::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
