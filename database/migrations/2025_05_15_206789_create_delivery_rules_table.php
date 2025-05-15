<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryRulesTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_rules', function (Blueprint $table) {
            $table->id();
            $table->decimal('threshold', 8, 2);
            $table->decimal('cost', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_rules');
    }
}
