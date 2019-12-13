<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100);
            $table->string('file_image', 1000);
            $table->string('file_miniature', 1000);
            /*
            se usan ?
            $table->integer('top');
            $table->integer('left');
            */
            $table->foreign('id_starting_points')->references('id')->on('points');
            $table->foreign('id_starting_scenes')->references('id')->on('scenes');
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
        Schema::dropIfExists('zones');
    }
}
