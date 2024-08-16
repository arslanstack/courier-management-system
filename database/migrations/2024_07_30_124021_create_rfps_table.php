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
        Schema::create('rfps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('route_type')->default(0)->comment('0: Dedicated, 1: Distribution');
            $table->tinyInteger('multiple_routes')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('vehicle_type')->default(0)->comment('0=Any, 1 - car, 2 - minivan, 3 - suv, 4 - cargo van, 5 - sprinter, 6 - covered pickup, 7 - 16 ft Box Truck, 8 - and so on till 14 - Tractor Trailer');
            $table->tinyInteger('reefer')->default(0)->comment('0=No, 1 Yes');
            $table->tinyInteger('hazmat')->default(0)->comment('0=No, 1 Yes');
            $table->tinyInteger('lift_gate')->default(0)->comment('0=No, 1 Yes');
            $table->string('start_point')->nullable();
            $table->string('delivery_point')->nullable();
            $table->text('description')->nullable();
            $table->string('frequency')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('estimated_mileage')->nullable();
            $table->string('insurance_coverage')->nullable();
            $table->string('bid_per_stop')->default(0)->comment('0: No, 1:Yes');
            $table->string('bid_per_route')->default(0)->comment('0: No, 1:Yes');
            $table->text('other_requirements')->nullable();
            $table->string('bid_due')->nullable();
            $table->text('recipients')->nullable();
            $table->string('doc_1')->nullable();
            $table->string('doc_2')->nullable();
            $table->string('contact_company')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfps');
    }
};
