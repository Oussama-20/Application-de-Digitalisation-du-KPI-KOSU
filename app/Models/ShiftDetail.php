<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id', 'hour', 'planned_operators', 'present_operators',
        'net_time', 'reference', 'coefficient', 'objective_quantity',
        'good_quantity', 'bad_quantity', 'kosu_real', 'comments'
    ];

    protected $casts = [
        'hour' => 'datetime:H:i',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // Mutator pour calculer automatiquement le KOSU réel avant sauvegarde
    public function setKosuRealAttribute($value)
    {
        $this->attributes['kosu_real'] = $value;
    }

    // Calcul du KOSU réel à partir des attributs
    public function calculateKosuReal()
    {
        if ($this->good_quantity > 0 && $this->coefficient > 0) {
            return round(($this->present_operators * $this->net_time) / ($this->good_quantity * $this->coefficient), 2);
        }
        return null;
    }
}