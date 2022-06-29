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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('year');
            $table->unsignedBigInteger('recruiter_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('recommender_id')->nullable();
            $table->string('project', 300)->nullable();
            $table->double('hours', 8, 2)->nullable();
            $table->string('category', 50)->nullable();
            $table->double('bonus', 8, 2)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('syncroner_id', 300)->nullable();
            $table->string('bitrix_id', 300)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('recruiter_id', 'recruiter_id_idx');
            $table->foreign('recruiter_id')->on('recruiters')->references('id');
            $table->index('client_id', 'client_id_idx');
            $table->foreign('client_id')->on('clients')->references('id');
            $table->index('recommender_id', 'recommender_id_idx');
            $table->foreign('recommender_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
