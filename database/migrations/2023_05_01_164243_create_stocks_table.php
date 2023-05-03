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
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('raw_material_id')->comment('Identificador del producto');
            $table->string('name')->comment('Nombre de la porción producida');
            $table->float('cost')->commnet('Costo de la porción producida');
            $table->float('mount')->comment('Precio a venta de la porción producida');
            $table->time('time')->nullable()->comment('Tiempo que toda producir la porición');
            $table->float('gain')->comment('Diferencia entre el costo y el precio de la porción producida');
            $table->boolean('active')->nullable()->default(true);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('raw_material_id')->references('id')->on('raw_materials');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
