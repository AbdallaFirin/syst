<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name'); // Or link to a vehicle/asset table if rigorous
            $table->string('maintenance_type'); // Repair, Inspection, Service
            $table->date('performed_at');
            $table->decimal('cost', 10, 2)->default(0);
            $table->text('details')->nullable();
            $table->string('performed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
