<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorInkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_ink', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('ink_id')->unsigned();
            $table->integer('cyan')->unsigned()->index();
            $table->integer('magenta')->unsigned()->index();
            $table->integer('yellow')->unsigned()->index();
            $table->integer('black')->unsigned()->index();
            $table->boolean('approved');
            $table->timestamps();

            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->foreign('ink_id')->references('id')->on('inks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_ink');
    }
}
