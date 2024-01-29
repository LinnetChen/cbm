<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvent240123Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event240123_item', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('master_id');
            $table->integer('probability');
            $table->integer('pray_probability');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event240123_item');
    }
}
