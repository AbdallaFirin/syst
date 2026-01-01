<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->text('recommendation_text');
            $table->string('priority')->default('Medium'); // High, Medium, Low
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_recommendations');
    }
};
