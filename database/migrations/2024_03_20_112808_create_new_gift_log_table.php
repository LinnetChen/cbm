<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewGiftLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_gift_log', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('gift');
            $table->string('gift_item');
            $table->string('ip');
            $table->string('tranNo');
            $table->integer('count');
            $table->string('is_send');
            $table->integer('server_id');
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
        Schema::dropIfExists('new_gift_log');
    }
}
