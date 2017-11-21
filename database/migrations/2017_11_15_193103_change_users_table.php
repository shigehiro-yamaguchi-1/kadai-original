<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 既にテーブルの対象カラムにNULLを登録しているならば必要
            // DB::statement('UPDATE `users` SET `password` = "" WHERE `password` IS NULL');

            // passwordカラムにNULLを許容しない
            DB::statement('ALTER TABLE `users` MODIFY `password` varchar NOT NULL;');
        });
    }
}
