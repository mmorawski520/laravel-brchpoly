<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
   

        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('board_id');
            $table->string('nickname');
            $table->unsignedInteger('players_balance');
            $table->boolean('bankrupt')->default(0);
            $table->timestamps();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
