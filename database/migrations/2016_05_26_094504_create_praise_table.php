<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePraiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praise', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creation_id')->unsigned();
            $table->integer('interest_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('action');
            $table->text('comment');
            $table->timestamps();
            $table->index(['creation_id', 'interests_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('praise');
    }
}
