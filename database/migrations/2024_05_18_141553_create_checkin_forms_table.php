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
        Schema::create('checkin_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('checkin_type_id');
            $table->foreign('checkin_type_id')->references('id')->on('check_in_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_forms');
    }
};
