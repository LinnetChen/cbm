<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_content', function (Blueprint $table) {
            $table->id();
            $table->integer('gift_group_id');
            $table->string('title');
            $table->string('description');
            $table->string('itemIdx');
            $table->string('itemOpt');
            $table->string('durationIdx');
            $table->string('prdId');
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
        Schema::dropIfExists('gift_content');
    }
}
