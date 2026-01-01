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
        Schema::create('fire_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('place_id')->constrained()->onDelete('cascade');
            $table->foreignId('incident_cause_id')->constrained('incident_causes');
            $table->dateTime('incident_date');
            $table->integer('human_loss')->default(0); // Number of deaths
            $table->integer('injured_people')->default(0);
            $table->decimal('financial_loss', 15, 2)->default(0);
            $table->integer('rescued_people')->default(0);
            $table->text('rescued_assets')->nullable();
            $table->text('additional_notes')->nullable();
            
            // We might want to link which team/vehicles attended, but that can be a pivot table later.
            // For now, let's keep it simple as per requirements.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fire_incidents');
    }
};
