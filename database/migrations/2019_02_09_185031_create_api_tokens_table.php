<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->string("token", 24);
            $table->string("ip", strlen("255.255.255.255"))->nullable()->default(null);
            $table->integer("user_id")->unsigned();
            $table->tinyInteger("user_role")->unsigned();
            $table->boolean("remember")->default(false);
            $table->timestamps();

            $table->unique("token");
            $table->index("token");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("api_tokens", function (Blueprint $table) {
            $table->dropUnique("api_tokens_token_unique");
            $table->dropIndex("api_token_token_index");
        });
        Schema::dropIfExists('api_tokens');
    }
}
