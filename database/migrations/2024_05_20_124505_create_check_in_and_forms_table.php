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
        Schema::create('check_in_and_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_in_id');
            $table->unsignedBigInteger('checkin_form_id');
            $table->timestamps();

            $table->foreign('check_in_id')->references('id')->on('check_ins')->onDelete('cascade');
            $table->foreign('checkin_form_id')->references('id')->on('checkin_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_in_and_forms');
    }
};
