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
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('Identificador del producto');
            $table->float('total')->comment('Total del gasto respecto a la cantidad de materia prima comprada');
            $table->string('quantity')->comment('Tipo de materia prima comprada (ej: 1lb. carne)');
            $table->integer('parts')->comment('Número de partes respecto a la materia prima adquirida');
            $table->float('cost')->comment('Estado de la materia prima');
            $table->boolean('active')->comment('Estado de la materia prima')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
