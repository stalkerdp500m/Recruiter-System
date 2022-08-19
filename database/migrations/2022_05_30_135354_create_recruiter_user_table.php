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
        Schema::create('recruiter_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('recruiter_id')->nullable();
            $table->timestamps();
            //  $table->index('user_id', 'user_id_idx');
            $table->foreign('user_id')->on('users')->references('id');
            $table->index('recruiter_id', 'recruiter_id_idx');
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
        Schema::dropIfExists('recruiter_user');
    }
};
