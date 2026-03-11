<?php
// database/migrations/2024_01_01_000000_create_excel_imports_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('excel_imports', function (Blueprint $table) {
            $table->id();
            $table->string('reference_rnlt')->nullable();
            $table->string('reference_sigip')->nullable();
            $table->decimal('temps_ass_min', 10, 2)->nullable();
            $table->decimal('temps_ass_h', 10, 2)->nullable();
            $table->decimal('efficience_e1', 10, 2)->nullable();
            $table->integer('effectif_e1')->nullable();
            $table->integer('effectif_kosu')->nullable();
            $table->decimal('temps_presence', 10, 2)->nullable();
            $table->decimal('nbr_heures_produire', 10, 2)->nullable();
            $table->string('cad_equipe')->nullable();
            $table->decimal('cad_h', 10, 2)->nullable();
            $table->decimal('t_cycle_m', 10, 2)->nullable();
            $table->decimal('t_cycle_s', 10, 2)->nullable();
            $table->decimal('coef', 10, 2)->nullable();
            $table->string('nom_fichier')->nullable();
            $table->timestamp('date_import')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('excel_imports');
    }
};