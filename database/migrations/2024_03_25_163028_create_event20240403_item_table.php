<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvent20240403ItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event240403_item', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('itemKind');
            $table->integer('itemOption');
            $table->integer('itemPeriod');
            $table->integer('count');
            $table->datetime('deliveryTime');
            $table->datetime('expirationTime');
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
        Schema::dropIfExists('event240403_item');
    }
}
