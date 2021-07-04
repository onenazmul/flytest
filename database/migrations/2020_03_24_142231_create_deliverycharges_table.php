<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverychargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverycharges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->length('151');
            $table->string('slug')->length('151');
            $table->string('subtitle')->length('191');
            $table->string('time')->length('55');
            $table->integer('deliverycharge')->length('55');
            $table->integer('extradeliverycharge')->length('55');
            $table->longText('description');
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
        Schema::dropIfExists('deliverycharges');
    }
}
