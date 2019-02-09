<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplineLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discipline_lesson', function (Blueprint $table) {
            $table->integer("discipline_id")->unsigned();
            $table->integer("lesson_id")->unsigned();

            $table->foreign("discipline_id")->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreign("lesson_id")->references('id')->on('lessons')->onDelete('cascade');

            $table->unique(["discipline_id", "lesson_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discipline_lesson', function (Blueprint $table) {
            $table->dropForeign("discipline_lesson_discipline_id_foreign");
            $table->dropForeign("discipline_lesson_lesson_id_foreign");
            $table->dropUnique("discipline_lesson_discipline_id_lesson_id_unique");
        });
        Schema::dropIfExists('discipline_lesson');
    }
}
