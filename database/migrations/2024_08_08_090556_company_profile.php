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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->tinyInteger('reefer')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('hazmat')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('lift_gate')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('24_hr_dispatch')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('tsa_certified')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('on_demand_service')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('scheduled_routes')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('distributed_delivery')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('warehouse_facility')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('climate_controlled')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('biohazard_exp')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('pharma_distribution')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('international_freight')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('indirect_aircarrier')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('gps_fleet_system')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('uniformed_drivers')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('interstate_service')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('whiteglove_service')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('process_legal_service')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('car')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('minivan')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('suv')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('cargo_van')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('sprinter')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('covered_pickup')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('16ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('18ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('20ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('22ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('24ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('26ft_truck')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('flatbed')->default(1)->comment('1=Yes, 0=No');
            $table->tinyInteger('tractor_trailer')->default(1)->comment('1=Yes, 0=No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
