<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            // $table->index('payment_id', 'payment_id_idx');
            // $table->foreign('payment_id', 'payment_id_fk')->on('payments')->references('id');
            // $table->index('user_id', 'user_id_idx');
            // $table->foreign('user_id', 'user_id_fk')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_user');
    }
};
