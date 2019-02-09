<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->timestamps();

            $table->foreign("lesson_id")->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign("student_id")->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign("visits_lesson_id_foreign");
            $table->dropForeign("visits_student_id_foreign");
        });
        Schema::dropIfExists('visits');
    }
}
