<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverymenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverymen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('area');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('designation');
            $table->string('password');
            $table->string('image')->default('public/avatar/avatar.png');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('deliverymen');
    }
}
