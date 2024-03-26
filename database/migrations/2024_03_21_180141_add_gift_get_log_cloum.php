<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiftGetLogCloum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_getlog', function (Blueprint $table) {
            $table->string('type');
            $table->integer('server_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('gift_getlog', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('server_id');
        });
    }
}
