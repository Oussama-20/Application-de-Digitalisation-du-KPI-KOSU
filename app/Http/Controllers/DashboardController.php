<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use App\Models\Reference; // Ajouter cette lignes

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role ?? 'shift_leader';
        $data = $this->getDashboardData($role);
        return view('dashboard', $data);
    }

    public function superviseur()
    {
        $data = $this->getDashboardData('superviseur');
        return view('dashboard.superviseur', $data);
    }

    public function methodes()
    {
        $data = $this->getDashboardData('methodes');
        return view('dashboard.methodes', $data);
    }

    public function shift()
    {
        $data = $this->getDashboardData('shift_leader');
        return view('dashboard.shift', $data);
    }

    private function getDashboardData($role)
    {
        // Récupérer tous les shifts avec leurs détails (pour éviter N+1)
        $allShifts = Shift::with('details')->get();

        // Calculer les statistiques en fonction du KOSU global
        $totalShifts = $allShifts->count();
        $shiftsBons = 0;
        $shiftsAttention = 0;
        $shiftsCritiques = 0;

        foreach ($allShifts as $shift) {
            $kosu = $shift->global_kosu;
            if ($kosu === null) continue; // ou compter comme indéfini

            if ($kosu <= 1.0) {
                $shiftsBons++;
            } elseif ($kosu <= 1.15) {
                $shiftsAttention++;
            } else {
                $shiftsCritiques++;
            }
        }

        // 5 derniers shifts (avec détails)
        $recentShifts = Shift::with('details')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return compact(
            'role',
            'totalShifts',
            'shiftsBons',
            'shiftsAttention',
            'shiftsCritiques',
            'recentShifts',
        );
    }
}