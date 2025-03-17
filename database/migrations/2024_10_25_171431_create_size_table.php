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
        Schema::create('size', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_product_meta');
            $table->string('name_size');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_product_meta')->references('id')->on('product_meta')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('size', function (Blueprint $table) {
            //
        });
    }
};