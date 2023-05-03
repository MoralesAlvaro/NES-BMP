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
            $table->id();
            $table->unsignedInteger('status_sale_id');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('type_doc_id');
            $table->float('sup_total');
            $table->float('discount');
            $table->float('total');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_doc_id')->references('id')->on('type_docs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale');
    }
};
