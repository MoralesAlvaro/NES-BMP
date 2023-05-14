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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador único de la tabla');
            $table->string('name')->unique()->comment('Nombre del producto');
            $table->longText('description')->nullable()->comment('Dirección del producto');
            $table->unsignedInteger('category_id')->nullable()->comment('Identificador de categoria');
            $table->boolean('active')->default(true)->comment('Estado del producto');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
