<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'name',
        'coefficient',
        'ost',
        'kosu_objectif',
        'created_by',
        'description'
    ];

    protected $casts = [
        'coefficient' => 'decimal:2',
        'ost' => 'decimal:2',
        'kosu_objectif' => 'decimal:2',
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y'
    ];
}