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
        Schema::create('client_check_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('check_in_id');
            $table->boolean('notification_viewed')->default(false);


            $table->timestamps();

            // Define foreign keys
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('check_in_id')->references('id')->on('check_ins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_check_ins');
    }
};
