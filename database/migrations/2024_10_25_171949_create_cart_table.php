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
        Schema::create('cart', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_vocher')->nullable();
            $table->integer('total_quantity');
            $table->decimal('total_price', 15, 0);
            $table->string('payment_method');
            $table->string('shipping_method');
            $table->text('note')->nullable();
            $table->enum('status',['order','shipping','success','cancel'])->default('order');
            $table->date('date');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_vocher')->references('id')->on('vocher')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            //
        });
    }
};