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
        Schema::table('fire_incidents', function (Blueprint $table) {
            $table->enum('status', ['pending', 'investigating', 'resolved', 'closed'])->default('pending')->after('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fire_incidents', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
