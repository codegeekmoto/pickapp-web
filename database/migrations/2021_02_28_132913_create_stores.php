<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->string('dti')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('business_permit')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->boolean('activited')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
