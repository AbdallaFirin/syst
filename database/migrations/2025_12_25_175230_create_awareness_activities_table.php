<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awareness_activities', function (Blueprint $table) {
            $table->id();
            $table->string('activity_name');
            $table->string('location');
            $table->date('activity_date');
            $table->integer('beneficiaries_count');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awareness_activities');
    }
};
