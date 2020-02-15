<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("quiz_id")->index();
            $table->foreign("quiz_id")->references("id")->on("quizzes")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("quest_id")->index();
            $table->foreign("quest_id")->references("id")->on("questions")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("correct")->default("-1");
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
        Schema::dropIfExists('results');
    }
}
