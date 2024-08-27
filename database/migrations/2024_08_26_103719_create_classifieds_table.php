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
        Schema::create('classifieds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->string('screen_name')->nullable();
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->string('location')->nullable();
            $table->string('state')->nullable();
            $table->tinyInteger('category')->default(0)->comment('0: For Sale, 1: Help Wanted, 2: Other, 3: Position Sought, 4: Want to Purchase, 5: Warehousing');
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Inactive, 1: Active, 2: Expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifieds');
    }
};
