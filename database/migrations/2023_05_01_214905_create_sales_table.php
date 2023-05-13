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
            $table->increments('id');
            $table->unsignedInteger('status_sale_id')->comment('Identificador del registro del estatus de la venta');
            $table->unsignedInteger('user_id')->comment('Identificador del registro del usuario');
            $table->unsignedInteger('type_doc_id')->comment('Identificador del registro de la tipo de documento que pertenece esta venta');
            $table->float('sup_total')->comment('Total de según suma de todos los items que conforman la venta');
            $table->float('discount')->comment('Descuento global aplicado a la venta');
            $table->float('total')->comment('Total general de venta, aplicando descuentos');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('status_sale_id')->references('id')->on('status_sales');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_doc_id')->references('id')->on('type_docs');
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
