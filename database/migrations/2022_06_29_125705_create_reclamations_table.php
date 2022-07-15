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
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('status_id');
            $table->string('project', 300);
            $table->string('period', 50);
            $table->text('comment')->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->index('recruiter_id', 'recruiter_id_idx');
            $table->foreign('recruiter_id')->on('recruiters')->references('id');

            $table->index('user_id', 'user_id_idx');
            $table->foreign('user_id')->on('users')->references('id');

            $table->index('client_id', 'client_id_idx');
            $table->foreign('client_id')->on('clients')->references('id');

            $table->index('status_id', 'status_id_idx');
            $table->foreign('status_id')->on('reclamation_statuses')->references('id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclamations');
    }
};
