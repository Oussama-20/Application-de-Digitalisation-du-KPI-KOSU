<?php
// app/Models/ExcelImport.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelImport extends Model
{
    use HasFactory;

    protected $table = 'excel_imports';

    protected $fillable = [
        'reference_rnlt',
        'reference_sigip',
        'temps_ass_min',
        'temps_ass_h',
        'efficience_e1',
        'effectif_e1',
        'effectif_kosu',
        'temps_presence',
        'nbr_heures_produire',
        'cad_equipe',
        'cad_h',
        't_cycle_m',
        't_cycle_s',
        'coef',
        'nom_fichier',
        'date_import'
    ];

    protected $casts = [
        'date_import' => 'datetime',
        'temps_ass_min' => 'decimal:2',
        'temps_ass_h' => 'decimal:2',
        'efficience_e1' => 'decimal:2',
        'temps_presence' => 'decimal:2',
        'nbr_heures_produire' => 'decimal:2',
        'cad_h' => 'decimal:2',
        't_cycle_m' => 'decimal:2',
        't_cycle_s' => 'decimal:2',
        'coef' => 'decimal:2'
    ];
}