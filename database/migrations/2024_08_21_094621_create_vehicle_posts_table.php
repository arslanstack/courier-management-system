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
        Schema::create('vehicle_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->tinyInteger('route_type')->default(0)->comment('0: On Demand, 1: Scheduled');
            $table->tinyInteger('vehicle_type')->default(0)->comment('0: Car, 1: Bike, 2: Truck and so on');
            $table->string('date_available')->nullable();
            $table->string('start_city')->nullable();
            $table->string('start_state')->nullable();
            $table->string('start_zip')->nullable();
            $table->decimal('start_lat', 10, 6)->nullable();
            $table->decimal('start_lng', 10, 6)->nullable();
            $table->string('departure')->nullable();
            $table->string('destination_city')->nullable();
            $table->string('destination_state')->nullable();
            $table->string('destination_zip')->nullable();
            $table->decimal('destination_lat', 10, 6)->nullable();
            $table->decimal('destination_lng', 10, 6)->nullable();
            $table->string('arrival')->nullable();
            $table->string('mileage')->nullable();
            $table->tinyInteger('reefer')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('liftgate')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('hazmat')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('round_trip')->default(0)->comment('0: No, 1: Yes');
            $table->text('other_info')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active, 2: Expired, 3: Availed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_posts');
    }
};
