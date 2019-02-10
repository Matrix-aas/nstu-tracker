<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discipline_id')->unsigned();
            $table->string("name");
            $table->timestamp("datetime");
            $table->integer("professor_id")->unsigned();

            $table->foreign("discipline_id")->references('id')->on('disciplines')->onDelete('cascade');
            $table->foreign("professor_id")->references('id')->on('professors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign("lessons_discipline_id_foreign");
            $table->dropForeign("lessons_professor_id_foreign");
        });
        Schema::dropIfExists('lessons');
    }
}
