<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pending_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->json('cart');
            $table->integer('total');
            $table->string('code')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_orders');
    }
};
