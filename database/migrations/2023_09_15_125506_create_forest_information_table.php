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
        Schema::create('forest_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('forest_id'); // Forest ID
            $table->integer('tree_number')->unique(); // 立木ID
            $table->float('diameter')->nullable(); // 2cm括約胸高直径[cm]
            $table->float('height')->nullable(); // 樹高[m]
            $table->float('arrow_height')->nullable(); // 矢高[cm]
            $table->float('volume')->nullable(); // 2cm括約材積[m3]
            $table->float('biomass')->nullable(); // バイオマス（2cm括約）[kg]
            $table->string('species')->nullable(); // 樹種
            $table->float('longitude')->nullable(); // 経度（日本測地系）
            $table->float('latitude')->nullable(); // 緯度（日本測地系）
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
        Schema::dropIfExists('forest_information');
    }
};
