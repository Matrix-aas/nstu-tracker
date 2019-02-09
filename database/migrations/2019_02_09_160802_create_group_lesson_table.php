<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_lesson', function (Blueprint $table) {
            $table->integer("group_id")->unsigned();
            $table->integer("lesson_id")->unsigned();

            $table->foreign("group_id")->references('id')->on('groups')->onDelete('cascade');
            $table->foreign("lesson_id")->references('id')->on('lessons')->onDelete('cascade');

            $table->unique(["group_id", "lesson_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_lesson', function (Blueprint $table) {
            $table->dropForeign("group_lesson_group_id_foreign");
            $table->dropForeign("group_lesson_lesson_id_foreign");
            $table->dropUnique("group_lesson_group_id_lesson_id_unique");
        });
        Schema::dropIfExists('group_lesson');
    }
}
