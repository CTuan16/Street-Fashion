<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchKeywordTable extends Migration
{
    public function up()
    {
        Schema::create('search_keyword', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->integer('count')->default(0); // Thêm cột count với giá trị mặc định là 0
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_keyword');
    }
}
