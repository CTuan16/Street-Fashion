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
        Schema::create('product_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_product');
            $table->integer('quantity');
            $table->integer('sold')->default(0);
            $table->decimal('price', 15, 0);
            $table->decimal('price_sale', 15, 0)->default(0);
            $table->enum('default', ['default', 'no_default'])->default('no_default');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_meta', function (Blueprint $table) {
            //
        });
    }
};