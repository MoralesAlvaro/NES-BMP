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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->comment('Identificador único de la tabla');
            $table->string('name')->unique()->comment('Nombre de la categoría');
            $table->longText('description')->nullable()->comment('Dirección de la categoría');
            $table->boolean('active')->default(true)->comment('Estado de la categoría');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
