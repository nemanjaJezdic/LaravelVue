<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string("title");
            $table->text("desc");
            $table->text("text");
            $table->string("cover");
            $table->string("alt");
            $table->tinyInteger("news_type");
            $table->enum("status",['published','in process','archived']);
            $table->dateTime("created_at",$precision=0);
            $table->dateTime("published_at",$precision=0)->nullable();
            $table->dateTime("archived_at",$precision=0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
