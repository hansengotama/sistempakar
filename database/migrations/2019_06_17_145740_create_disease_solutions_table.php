<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseaseSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_solutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disease_id')->unsigned();
            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');
            $table->integer('solution_id')->unsigned();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');
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
        Schema::dropIfExists('disease_solutions');
    }
}
