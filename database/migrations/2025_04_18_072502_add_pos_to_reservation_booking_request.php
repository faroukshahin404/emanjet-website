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
        Schema::table('reservation_booking_requests', function (Blueprint $table) {
           $table->enum('pos', ['office', 'callcenter', 'website', 'application'])->default('office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_booking_request', function (Blueprint $table) {
            //
        });
    }
};
