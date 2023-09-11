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
        // 新しいカラムを追加
        Schema::table('forests', function (Blueprint $table) {
            $table->unsignedInteger('new_owner_id');
        });
    
        // 古いカラムを削除
        Schema::table('forests', function (Blueprint $table) {
            $table->dropColumn('owner_id');
        });
    
        // 新しいカラムの名前を変更
        Schema::table('forests', function (Blueprint $table) {
            $table->renameColumn('new_owner_id', 'owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 新しいカラムを追加
        Schema::table('forests', function (Blueprint $table) {
            $table->integer('new_owner_id', 11);
        });
    
        // 古いカラムを削除
        Schema::table('forests', function (Blueprint $table) {
            $table->dropColumn('owner_id');
        });
    
        // 新しいカラムの名前を変更
        Schema::table('forests', function (Blueprint $table) {
            $table->renameColumn('new_owner_id', 'owner_id');
        });
    }
};