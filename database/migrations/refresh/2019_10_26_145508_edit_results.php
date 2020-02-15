<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
          $table->unsignedBigInteger("quiz_id")->index();
          $table->foreign("quiz_id")->references("id")->on("quizzes")->onDelete("cascade")->onUpdate("cascade");
          $table->unsignedBigInteger("quest_id")->index();
          $table->foreign("quest_id")->references("id")->on("questions")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn("quiz_id");
            $table->dropColumn("quest_id");
        });
    }
}
