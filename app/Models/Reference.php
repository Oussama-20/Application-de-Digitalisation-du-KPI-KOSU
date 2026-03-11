<?php
// app/Models/Reference.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'coefficient',
        'ost',
        'kosu_objectif',
        'pourcentage_15',
        'pourcentage_25',
        'pourcentage_35',
        'created_by'
    ];
}