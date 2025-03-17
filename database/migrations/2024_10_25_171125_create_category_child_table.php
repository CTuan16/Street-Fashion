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
        Schema::create('category_child', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_parent');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_parent')->references('id')->on('category_parent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_child', function (Blueprint $table) {
            //
        });
    }
};