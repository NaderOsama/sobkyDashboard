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
    Schema::create('form_answers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_check_in_id');
        $table->foreign('client_check_in_id')->references('id')->on('client_check_ins')->onDelete('cascade');
        $table->foreignId('question_id')->constrained()->onDelete('cascade');
        $table->text('answer');
        $table->integer('remaining_days')->nullable();
        $table->timestamps();

    });
    }


    public function down()
    {
        Schema::dropIfExists('form_answers');
    }
};
