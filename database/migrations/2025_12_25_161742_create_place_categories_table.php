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
        Schema::create('place_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('policy_id')->nullable(); // We'll add the foreign key constraint later or usually it's better to add after both tables exist, or just use simpler unsignedBigInteger if Policy migration is later. Wait, Policy is later. Let's just make it nullable unsignedBigInteger for now.
            $table->text('required_equipment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_categories');
    }
};
