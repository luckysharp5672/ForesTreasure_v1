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
        Schema::create('tree_layout_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('forest_id');
            $table->string('filename');
            $table->timestamps();
    
            $table->foreign('forest_id')->references('id')->on('forests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tree_layout_images');
    }
};
