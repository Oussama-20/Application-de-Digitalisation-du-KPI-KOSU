<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_shifts_table.php

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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('team_speaker'); // équipe
            $table->string('supervisor'); // superviseur
            $table->string('segment'); // segment
            $table->string('line'); // ligne (L1, L2...)
            $table->foreignId('user_id')->constrained('accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};