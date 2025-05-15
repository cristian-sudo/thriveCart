<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('product_code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
