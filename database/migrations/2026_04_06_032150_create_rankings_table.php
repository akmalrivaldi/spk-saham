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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')->constrained('periods')->cascadeOnDelete();
            $table->foreignId('stock_id')->constrained('stocks')->cascadeOnDelete();

            $table->decimal('vector_s', 20, 10);
            $table->decimal('vector_v', 20, 10);
            $table->unsignedInteger('rank');

            $table->timestamps();

            $table->unique(['period_id', 'stock_id'], 'period_stock_ranking_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};