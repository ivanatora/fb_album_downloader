<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatAlbumsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fb_id', 255);
            $table->string('name', 255)->default('');
            $table->string('link', 255)->default('');
            $table->string('author_name', 255)->default('');
            $table->string('author_id', 255)->default('');
            $table->dateTime('created_time');
            $table->text('description');
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('album_id');
            $table->string('picture_url', 255)->default('');
            $table->string('picture_id', 255)->default('');
            $table->dateTime('created_time');
            $table->text('name');

            $table->index('album_id');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('photo_id')->nullable();
            $table->unsignedInteger('album_id')->nullable();
            $table->dateTime('created_time');
            $table->string('poster_name', 255);
            $table->string('poster_id', 255);
            $table->text('message');

            $table->index('photo_id');
            $table->foreign('photo_id')->references('id')->on('photos')->onDelete('cascade');

            $table->index('album_id');
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('comments');
        Schema::dropIfExists('photos');
        Schema::dropIfExists('albums');
    }
}
