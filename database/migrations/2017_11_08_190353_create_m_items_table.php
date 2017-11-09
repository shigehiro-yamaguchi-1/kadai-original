<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('title_short1');
            $table->string('title_short2');
            $table->string('title_short3');
            $table->string('public_url', 2083)->default('');
            $table->string('twitter_account');
            $table->string('twitter_hash_tag');
            $table->string('profile_banner_url', 2083)->default('');
            $table->integer('year')->unsigned();
            $table->integer('season')->unsigned();
            $table->integer('cours_id')->unsigned();
            $table->integer('sex')->unsigned();
            $table->integer('sequel')->unsigned();
            $table->integer('ganre_id')->unsigned();
            $table->timestamps();
            $table->index(['year','cours_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_items');
    }
}
