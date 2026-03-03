<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_references_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // REF-A100, REF-B200, etc.
            $table->string('name')->nullable(); // Nom optionnel de la référence
            $table->decimal('coefficient', 8, 2); // Coefficient (1.2, 1.5, etc.)
            $table->decimal('ost', 8, 2)->nullable(); // OST (Operation Standard Time)
            $table->decimal('kosu_objectif', 8, 2)->nullable(); // KOSU Objectif
            $table->string('created_by')->default('ME001'); // Créé par
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('references');
    }
};