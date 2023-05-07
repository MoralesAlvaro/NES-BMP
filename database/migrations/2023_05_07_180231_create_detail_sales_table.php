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
        Schema::create('detail_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sale_id')->comment('Identificador de la venta asociado a este detalle');
            $table->unsignedInteger('stock_id')->comment('Identificador del registro de stock');
            $table->unsignedInteger('type_product_id')->comment('Identificador del registro del tipo de producto');
            $table->float('discount')->comment('Descuento de la orden o porción')->nullable();
            $table->float('total')->comment('Total de la orden o porción');
            $table->float('orders')->comment('Total de ordenes de este producto');

            $table->timestamps();

            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('type_product_id')->references('id')->on('type_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sales');
    }
};
