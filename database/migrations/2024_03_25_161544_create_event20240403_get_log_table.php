<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvent20240403GetLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event240403_get_log', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('ip');
            $table->integer('server_id');
            $table->integer('gift');
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
        Schema::dropIfExists('event240403_get_log');
    }
}
