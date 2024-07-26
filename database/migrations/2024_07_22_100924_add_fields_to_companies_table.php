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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->string('drivers')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('gen_liability')->nullable();
            $table->string('cargo_insurance')->nullable();
            $table->string('other_insurance')->nullable();
            $table->string('insurance_declaration')->nullable();
            $table->string('insurance_expiration')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('website');
            $table->dropColumn('drivers');
            $table->dropColumn('insurance_company');
            $table->dropColumn('gen_liability');
            $table->dropColumn('cargo_insurance');
            $table->dropColumn('other_insurance');
            $table->dropColumn('insurance_declaration');
            $table->dropColumn('insurance_expiration');
            $table->dropColumn('company_phone');
            $table->dropColumn('company_mobile');
        });
    }
};
