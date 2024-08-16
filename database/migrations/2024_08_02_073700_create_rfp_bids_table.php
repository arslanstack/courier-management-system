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
        Schema::create('rfp_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rfp_id');
            $table->unsignedBigInteger('user_id');
            $table->string('amount')->nullable();
            $table->text('terms');
            $table->tinyInteger('status')->default(0)->comment('0 : listed, 1 : unlisted , 2 : accepted 3 : completed, 4: removed ');
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
        Schema::dropIfExists('rfp_bids');
    }
};
