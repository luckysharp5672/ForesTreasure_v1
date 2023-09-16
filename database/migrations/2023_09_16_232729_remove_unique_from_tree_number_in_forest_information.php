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
        Schema::table('forest_information', function (Blueprint $table) {
            // 一意性制約を削除
            $table->dropUnique('forest_information_tree_number_unique');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forest_information', function (Blueprint $table) {
            // 一意性制約を再度追加（ロールバック時の動作）
            $table->unique('tree_number');
        });
    }
};
