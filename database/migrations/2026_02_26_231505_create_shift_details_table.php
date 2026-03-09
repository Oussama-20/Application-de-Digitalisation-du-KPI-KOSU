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
            $table->string('ref_client'); // REF CLIENT (240104514V)
            $table->string('angle_ref'); // ANGLE REF (240108387S)
            $table->decimal('tom', 5, 2); // T.O.M (2.93)
            $table->integer('efficiency'); // EFFICIENCY (74%)
            $table->integer('cost'); // COST (18)
            $table->integer('target_kosu'); // TARGET KOSU (198)
            $table->decimal('coeff_15', 4, 2); // 15% (1.08)
            $table->decimal('coeff_25', 4, 2); // 25% (1.07)
            $table->decimal('coeff_35', 4, 2); // 35% (1.06)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_details');
    }
};