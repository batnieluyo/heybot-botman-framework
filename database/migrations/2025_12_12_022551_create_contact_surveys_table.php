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
        Schema::create('contact_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('is_for');
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_surveys');
    }
};
