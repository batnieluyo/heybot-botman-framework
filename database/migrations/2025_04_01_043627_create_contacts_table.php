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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 16)->unique()->index();
            $table->string('display_name')->nullable();
            $table->string('current_group', 50)->nullable();
            $table->string('current_stage', 50)->default('default');
            $table->dateTime('message_received_at')->nullable();
            $table->dateTime('message_send_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
