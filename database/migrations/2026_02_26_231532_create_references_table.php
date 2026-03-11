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
        $table->string('reference')->unique();
        $table->decimal('coefficient', 8, 2);
        
        // OST (obligatoire maintenant)
        $table->decimal('ost', 8, 2);
        
        // KOSU Objectif (obligatoire maintenant)
        $table->decimal('kosu_objectif', 8, 2);
        
        // Pourcentages (obligatoires maintenant)
        $table->decimal('pourcentage_15', 8, 2);
        $table->decimal('pourcentage_25', 8, 2);
        $table->decimal('pourcentage_35', 8, 2);
        
        $table->string('created_by')->default('ME001');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('references');
    }
};