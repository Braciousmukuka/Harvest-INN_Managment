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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_number')->unique();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->decimal('quantity_sold', 10, 2);
            $table->string('quantity_unit');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'mobile_money', 'bank_transfer', 'credit']);
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->date('sale_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->index(['sale_date', 'status']);
            $table->index(['customer_name']);
            $table->index(['payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
