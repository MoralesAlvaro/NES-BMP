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
        Schema::create('raw_product', function (Blueprint $table) {
            $table->id();
            $table->decimal('price',4,2);
            $table->unsignedBigInteger('product_name_id');
            $table->integer('n_pieces');
            $table->integer('n_units');
            $table->decimal('cost_unit',8,2);
            $table->timestamps();
            $table->foreign('product_name_id')->references('id')->on('raw_product_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_product');
    }
};
