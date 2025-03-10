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
        Schema::create('checkin_form_question', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkin_form_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            $table->foreign('checkin_form_id')->references('id')->on('checkin_forms')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_form_question');
    }
};
