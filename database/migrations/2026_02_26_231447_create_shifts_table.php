<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_shifts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('team_speaker')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('line'); // L1, L2...
            $table->foreignId('user_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

     public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }
};