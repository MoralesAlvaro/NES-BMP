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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Nombres del usuario');
            $table->string('surname', 255)->nullable()->comment('Apellidos del usuario');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telephone', 9)->nullable()->comment('Telefono del usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_photo_path')->nullable()->comment('Dirección de la foto de perfil de la cuenta');
            $table->boolean('active')->nullable()->default(true)->comment('Habilitado e inhabilitado');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
