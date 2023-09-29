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
        Schema::table('work_requests', function (Blueprint $table) {
            $table->boolean('forester_approved')->default(false);
            $table->boolean('owner_approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_requests', function (Blueprint $table) {
            $table->dropColumn('forester_approved');
            $table->dropColumn('owner_approved');
        });
    }
};
