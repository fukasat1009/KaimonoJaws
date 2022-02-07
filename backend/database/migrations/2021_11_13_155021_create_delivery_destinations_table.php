<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_destinations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('prefecture');
            $table->string('city');
            $table->string('block');
            $table->integer('postal_code');
            $table->string('building')->nullable();
            $table->integer('room_number')->nullable();
            $table->string('phone_number');
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
        Schema::dropIfExists('delivery_destinations');
    }
}
