<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesRatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_rateds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id');
            $table->integer('user_id');
            $table->tinyInteger('rate');
            $table->timestamps();
            $table->unique(['series_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_rateds');
    }
}
