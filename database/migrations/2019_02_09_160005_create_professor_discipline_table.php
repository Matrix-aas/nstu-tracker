<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorDisciplineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_discipline', function (Blueprint $table) {
            $table->integer("professor_id")->unsigned();
            $table->integer("discipline_id")->unsigned();

            $table->foreign("professor_id")->references('id')->on('professors')->onDelete('cascade');
            $table->foreign("discipline_id")->references('id')->on('disciplines')->onDelete('cascade');

            $table->unique(["professor_id", "discipline_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professor_discipline', function (Blueprint $table) {
            $table->dropForeign("professor_discipline_professor_id_foreign");
            $table->dropForeign("professor_discipline_discipline_id_foreign");
            $table->dropUnique("professor_discipline_professor_id_discipline_id_unique");
        });
        Schema::dropIfExists('professor_discipline');
    }
}
