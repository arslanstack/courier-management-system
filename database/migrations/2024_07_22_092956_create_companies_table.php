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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mail_address_1')->nullable();
            $table->string('mail_address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();
            $table->tinyInteger('company_type')->default(0)->comment('0: Shipper 1: 3rd Party 2: Freight 3: Courier');
            $table->string('motor_carrier_no')->nullable();
            $table->string('dot_no')->nullable();
            $table->string('intrastate_no')->nullable();
            $table->string('alert_email_1')->nullable();
            $table->string('alert_email_2')->nullable();
            $table->tinyInteger('alert_freight')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('alert_vehicle')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('alert_rpf')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('alert_driver')->default(0)->comment('0: No, 1: Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
