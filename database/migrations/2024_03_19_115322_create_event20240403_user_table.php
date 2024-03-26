<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvent20240403UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event240403_user', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_type');
            $table->string('server_01_code')->nullable();
            $table->string('server_02_code')->nullable();
            $table->text('info');
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
        Schema::dropIfExists('event240403_user');
    }
}
