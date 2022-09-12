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
        Schema::create('add_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('recruiter_id')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->double('summ', 8, 2)->nullable();
            $table->string('type', 100)->nullable();
            $table->index('recruiter_id', 'add_payments_recruiter_idx');
            $table->foreign('recruiter_id')->on('recruiters')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_payments');
    }
};
