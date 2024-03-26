<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewGiftContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_gift_content', function (Blueprint $table) {
            $table->id();
            $table->integer('gift_group_id');
            $table->integer('itemKind');
            $table->integer('itemOption');
            $table->integer('itemPeriod');
            $table->integer('count');
            $table->string('title');
            $table->integer('serverIdx');
            $table->dateTime('deliveryTime');
            $table->dateTime('expirationTime');
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
        Schema::dropIfExists('new_gift_content');
    }
}
