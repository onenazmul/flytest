<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName')->length('25');
            $table->string('lastName')->length('40');
            $table->string('companyName')->length('191');
            $table->string('pickLocation')->length('100')->nullable();
            $table->integer('phoneNumber');
            $table->string('emailAddress')->length('30');
            $table->integer('nearestZone')->nullable();
            $table->integer('pickupPreference')->nullable();
            $table->tinyInteger('socialLink')->nullable();
            $table->tinyInteger('paymentMethod')->length('2')->nullable();
            $table->tinyInteger('withdrawal')->length('2')->nullable();
            $table->string('nameOfBank')->length('191')->nullable();
            $table->string('bankBranch')->length('191')->nullable();
            $table->string('bankAcHolder')->length('191')->nullable();
            $table->integer('bankAcNo')->nullable();
            $table->integer('bkashNumber')->nullable();
            $table->integer('roketNumber')->nullable();
            $table->integer('nogodNumber')->nullable();
            $table->integer('balance')->nullable();
            $table->string('password')->length('90');
            $table->string('logo')->default('public/uploads/default/avator.png');
            $table->tinyInteger('status')->length('2')->nullable();
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
        Schema::dropIfExists('merchants');
    }
}
