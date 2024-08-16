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
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->decimal('start_lat',10,8)->nullable();
            $table->decimal('start_long',10,8)->nullable();
            $table->decimal('dellivery_lat',10,8)->nullable();
            $table->decimal('dellivery_long',10,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn('start_lat');
            $table->dropColumn('start_long');
            $table->dropColumn('dellivery_lat');
            $table->dropColumn('dellivery_long');
        });
    }
};
