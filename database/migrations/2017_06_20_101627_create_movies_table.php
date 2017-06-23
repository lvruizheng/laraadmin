<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->integer('director')->unsigned();
            $table->string('describe');
            $table->tinyInteger('rate')->unsigned();
            $table->enum('released', array('0', '1'));
            $table->timestamp('release_at');
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
        //
    }
}
