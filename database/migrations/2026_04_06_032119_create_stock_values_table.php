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
        Schema::create('stock_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stock_id')->constrained('stocks')->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained('criteria')->cascadeOnDelete();

            $table->decimal('value', 15, 4);

            $table->timestamps();

            $table->unique(['stock_id', 'period_id', 'criterion_id'], 'stock_period_criterion_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_values');
    }
};