<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mg_petitions', function(Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('title');
          $table->text('body');
          $table->text('answer')->nullable();
          $table->integer('status');
          $table->integer('check');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mg_petitions');
    }
}
