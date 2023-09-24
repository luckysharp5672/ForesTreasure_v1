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
        Schema::create('work_requests', function (Blueprint $table) {
            $table->id('work_id');
            $table->unsignedInteger('requester_id');
            $table->unsignedInteger('forest_id');
            $table->unsignedInteger('forester_id');
            $table->string('work_type'); // 作業種別
            $table->date('desired_completion_date'); // 作業完了希望日
            $table->date('request_date'); // 作業依頼日
            $table->date('approval_date')->nullable(); // 作業承認日
            $table->date('completion_date')->nullable(); // 作業完了日
            $table->timestamps();
    
            $table->foreign('requester_id')->references('id')->on('users');
            $table->foreign('forest_id')->references('id')->on('forests');
            $table->foreign('forester_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_requests');
    }
};
