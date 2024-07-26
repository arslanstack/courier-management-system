<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->tinyInteger('billing_info_status')->default(0)->comment('0: Not Added, 1: Added');
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('expiry_month')->nullable();
            $table->string('expiry_year')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('billing_info_status');
            $table->dropColumn('card_number');
            $table->dropColumn('cvv');
            $table->dropColumn('expiry_month');
            $table->dropColumn('expiry_year');
        });
    }
};
