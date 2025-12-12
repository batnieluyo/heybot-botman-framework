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
        Schema::create('contact_survey_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id');
            $table->unsignedBigInteger('survey_question_id');
            $table->unsignedBigInteger('survey_question_option_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_survey_answers');
    }
};
