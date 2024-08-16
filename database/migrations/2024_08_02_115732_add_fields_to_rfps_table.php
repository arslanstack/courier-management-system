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
        Schema::table('rfps', function (Blueprint $table) {
            $table->string('start_city')->nullable();
            $table->string('start_state')->nullable();
            $table->string('start_zip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rfps', function (Blueprint $table) {
            $table->dropColumn('start_city');
            $table->dropColumn('start_state');
            $table->dropColumn('start_zip');
        });
    }
};
