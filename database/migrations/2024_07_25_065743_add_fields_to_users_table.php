<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('has_acc_info')->default(0)->after('is_major_user');
            $table->tinyInteger('has_post_func')->default(0)->after('is_major_user');
            $table->tinyInteger('has_alerts')->default(0)->after('is_major_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_acc_info');
            $table->dropColumn('has_post_func');
            $table->dropColumn('has_alerts');
        });
    }
};
