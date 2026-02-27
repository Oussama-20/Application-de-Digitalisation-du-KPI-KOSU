<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_shift_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shift_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained()->onDelete('cascade');
            $table->time('hour'); // Heure de la ligne
            $table->integer('planned_operators')->default(0);
            $table->integer('present_operators')->default(0);
            $table->decimal('net_time', 5, 2)->default(0); // heures
            $table->string('reference')->nullable();
            $table->decimal('coefficient', 8, 2)->default(1);
            $table->integer('objective_quantity')->default(0); // Quantité obj.
            $table->integer('good_quantity')->default(0);      // Quantité bonnes
            $table->integer('bad_quantity')->default(0);       // Quantité mauvaises
            $table->decimal('kosu_real', 8, 2)->nullable();    // Calculé
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_details');
    }
};