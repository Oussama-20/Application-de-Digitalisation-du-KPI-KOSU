<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'team_speaker', 'supervisor', 'line', 'user_id'];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(ShiftDetail::class);
    }

    // Calcul du KOSU global du shift
    public function getGlobalKosuAttribute()
    {
        $totalNumerator = $this->details->sum(function ($detail) {
            return $detail->present_operators * $detail->net_time;
        });
        $totalDenominator = $this->details->sum(function ($detail) {
            return $detail->good_quantity * $detail->coefficient;
        });

        return $totalDenominator > 0 ? round($totalNumerator / $totalDenominator, 2) : null;
    }

    // Taux de défauts global
    public function getDefectRateAttribute()
    {
        $totalGood = $this->details->sum('good_quantity');
        $totalBad = $this->details->sum('bad_quantity');
        $total = $totalGood + $totalBad;
        return $total > 0 ? round(($totalBad / $total) * 100, 2) : 0;
    }

    // Production totale
    public function getTotalProductionAttribute()
    {
        return $this->details->sum('good_quantity');
    }
}