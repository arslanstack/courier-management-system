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
        Schema::create('driver_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->tinyInteger('type')->default(1)->comment('0: Independent, 1: Full Time, 2: Part time, 3: Temporary, 4: Seasonal');
            $table->string('compensation')->nullable();
            $table->string('compensation_type')->nullable();
            $table->string('vehicle_types')->nullable();
            $table->tinyInteger('reefer')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('hazmat')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('lift_gate')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('tsa_certified')->default(0)->comment('0: No, 1: Yes');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->tinyInteger('experience')->default(0)->comment('0: Any, 1: 0-6 mo, 2: 7-12 mo, 3: 13-18 mo, 4: 19-24 mo, 5: more than 24 mo');
            $table->string('insurance_coverage')->nullable();
            $table->string('company_name')->nullable(); 
            $table->tinyInteger('show_company_name')->default(1)->comment('0: No, 1: Yes');
            $table->string('ad_title')->nullable();
            $table->mediumText('description')->nullable();    
            $table->mediumText('response_info')->nullable();    
            $table->string('company_logo')->nullable();    
            $table->string('contact_email')->nullable();    
            $table->string('div_id')->nullable();    
            $table->string('fee')->nullable();    
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active, 2: Expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_ads');
    }
};
