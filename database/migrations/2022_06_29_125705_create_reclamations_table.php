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
            $table->unsignedBigInteger('answerer_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('status_id');
            $table->string('project', 300);
            $table->string('period', 50);
            $table->json('comments')->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->index('recruiter_id', 'reclamations_recruiter_idx');
            $table->foreign('recruiter_id')->on('recruiters')->references('id');

            $table->index('user_id', 'reclamations_user_idx');
            $table->foreign('user_id')->on('users')->references('id');

            $table->index('client_id', 'reclamations_client_idx');
            $table->foreign('client_id')->on('clients')->references('id');

            $table->index('status_id', 'reclamations_status_idx');
            $table->foreign('status_id')->on('reclamation_statuses')->references('id');

            $table->index('answerer_id', 'reclamations_answerer_idx');
            $table->foreign('answerer_id')->on('users')->references('id');

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
