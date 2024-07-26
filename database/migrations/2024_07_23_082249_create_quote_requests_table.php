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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pickup_date')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('start_point')->nullable();
            $table->string('pickup_address_1')->nullable();
            $table->string('pickup_address_2')->nullable();
            $table->string('pickup_city')->nullable();
            $table->string('pickup_state')->nullable();
            $table->string('pickup_zip')->nullable();
            $table->string('pickup_contact_name')->nullable();
            $table->string('pickup_contact_phone')->nullable();
            $table->string('pickup_contact_email')->nullable();
            $table->string('pickup_company')->nullable();
            $table->string('delivery_point')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('delivery_address_1')->nullable();
            $table->string('delivery_address_2')->nullable();
            $table->string('delivery_city')->nullable();
            $table->string('delivery_state')->nullable();
            $table->string('delivery_zip')->nullable();
            $table->string('delivery_contact_name')->nullable();
            $table->string('delivery_contact_phone')->nullable();
            $table->string('delivery_contact_email')->nullable();
            $table->string('delivery_company')->nullable();
            $table->string('estimated_mileage')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('vehicle')->default(0)->comment('0=Any, 1 - car, 2 - minivan, 3 - suv, 4 - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer');
            $table->tinyInteger('reefer')->default(0)->comment('0=No, 1 Yes');
            $table->tinyInteger('hazmat')->default(0)->comment('0=No, 1 Yes');
            $table->tinyInteger('lift_gate')->default(0)->comment('0=No, 1 Yes');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
