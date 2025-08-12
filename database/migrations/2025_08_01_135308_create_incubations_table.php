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
        Schema::create('incubations', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->string('batch_name');
            $table->enum('egg_type', ['chicken', 'duck', 'goose', 'turkey', 'guinea_fowl', 'quail']);
            $table->string('breed')->nullable();
            $table->integer('eggs_placed');
            $table->integer('eggs_candled')->default(0);
            $table->integer('eggs_fertile')->default(0);
            $table->integer('eggs_hatched')->default(0);
            $table->integer('chicks_healthy')->default(0);
            $table->date('start_date');
            $table->date('expected_hatch_date');
            $table->date('actual_hatch_date')->nullable();
            $table->integer('incubation_days');
            $table->decimal('temperature_celsius', 4, 1)->default(37.5);
            $table->decimal('humidity_percent', 5, 2)->default(55.0);
            $table->enum('status', ['active', 'hatching', 'completed', 'failed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->json('daily_logs')->nullable(); // For tracking daily temperature, humidity, turning
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incubations');
    }
};
