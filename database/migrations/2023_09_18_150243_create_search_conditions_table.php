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
        Schema::create('search_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('condition_name');
            $table->text('numeric_conditions')->nullable(); // JSON形式で数値フィールドの条件を保存
            $table->text('species_conditions')->nullable(); // JSON形式で種類の条件を保存
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('radius', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_conditions');
    }
};
