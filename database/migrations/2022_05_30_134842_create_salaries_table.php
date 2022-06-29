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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->integer('month');
            $table->integer('year');
            $table->string('project', 300)->nullable();
            $table->double('hours', 8, 2)->nullable();
            $table->double('salary', 8, 2)->nullable();
            $table->double('rate', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('client_id', 'client_id_idx');
            $table->foreign('client_id')->on('clients')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
