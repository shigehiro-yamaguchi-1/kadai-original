<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonRankingDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_ranking_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->unsigned();
            $table->integer('season')->unsigned();
            $table->integer('rank')->unsigned();
            $table->integer('score');
            $table->integer('item_id')->unsigned();
            $table->string('title');
            $table->string('profile_image', 2083);
            $table->integer('high_rate');
            $table->integer('low_rate');
            $table->timestamps();
            $table->index(['year','season']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_ranking_datas');
    }
}
