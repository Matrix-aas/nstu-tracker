<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string("login");
            $table->string("password");
            $table->string("firstname");
            $table->string("surname");
            $table->string("middlename");
            $table->string("device_uid");
            $table->integer("group_id")->unsigned();
            $table->timestamps();

            $table->foreign("group_id")->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign("students_group_id_foreign");
        });
        Schema::dropIfExists('students');
    }
}
