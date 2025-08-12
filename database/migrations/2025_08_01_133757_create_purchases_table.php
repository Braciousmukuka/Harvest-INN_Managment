<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number')->unique();
            $table->string('supplier_name');
            $table->string('supplier_contact')->nullable();
            $table->string('supplier_email')->nullable();
            $table->text('supplier_address')->nullable();
            
            // Purchase items
            $table->string('item_name');
            $table->text('item_description')->nullable();
            $table->string('category'); // seeds, fertilizer, equipment, feed, etc.
            $table->decimal('quantity', 10, 2);
            $table->string('quantity_unit'); // kg, pieces, liters, etc.
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            
            // Purchase details
            $table->date('purchase_date');
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['pending', 'ordered', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'overdue'])->default('pending');
            $table->text('notes')->nullable();
            
            // Storage/Location
            $table->string('storage_location')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
