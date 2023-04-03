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
        Schema::create('details_sale', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->unsignedBigInteger('stock_id');
            $table->decimal('amount', 5, 2);
            $table->integer('discount');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sale_id');
            $table->timestamps();
            $table->foreign('stock_id')->references('id')->on('stock');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('sale_id')->references('id')->on('sale');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_sale');
    }
};
