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
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('id_category_parent');
            $table->unsignedBigInteger('id_category_child');
            $table->string('slug');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('primary_image')->nullable();
            $table->integer('quantity_favorite')->default(0);
            $table->text('second_image')->nullable();
            $table->integer('rate')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_category_parent')->references('id')->on('category_parent')->onDelete('cascade');
            $table->foreign('id_category_child')->references('id')->on('category_child')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            //
        });
    }
};