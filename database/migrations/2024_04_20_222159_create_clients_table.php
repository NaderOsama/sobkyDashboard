<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('second_mobile')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('diet_restrictions', ['Muslim', 'Christian'])->nullable();
            $table->string('email')->nullable();
            $table->string('job_title')->nullable();
            $table->unsignedBigInteger('group_id')->nullable(); // Make group_id nullable if needed
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('client_type')->nullable();
            $table->enum('referred_by', ['Website', 'Facebook Ads', 'Instagram Ads', 'Facebook', 'Instagram', 'Friend'])->nullable();
            $table->text('notes')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('status', ['not subscribed', 'subscribed', 'expired', 'paused'])->default('not subscribed');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes
        });

        // Adding indexes
        Schema::table('clients', function (Blueprint $table) {
            $table->index('group_id');
            $table->index('user_id');
        });
    }


    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
