<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HubbleBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('name');
            $table->json('data')->nullable();
            $table->string('key');
            $table->timestamps();
        });

        Schema::create('devices-data', function (Blueprint $table) {
            $table->increments('id');
            $table->string("device_id");
            $table->json("data");
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
        Schema::drop('devices');
        Schema::drop('devices-data');
    }
}
