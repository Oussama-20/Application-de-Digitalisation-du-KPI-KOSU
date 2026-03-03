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