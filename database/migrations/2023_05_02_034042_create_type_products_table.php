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
        Schema::create('type_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Nombre del tipo producto (A la planta, Al Carbón)')->unique();
            $table->float('cost')->comment('Costo adicional sumado al precio de la orden de producto');
            $table->longText('description')->comment('Descripción del ítem')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_products');
    }
};
