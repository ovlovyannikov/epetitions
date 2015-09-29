<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignPetitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mg_signs', function(Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('signable_id');
          $table->string('signable_type');
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
        Schema::drop('mg_signs');
    }
}
