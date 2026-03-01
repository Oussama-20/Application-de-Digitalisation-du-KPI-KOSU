<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role ?? 'shift leader';
        
        // Statistiques dynamiques depuis la base de données
        $totalShifts = Shift::count();
        $shiftsBons = Shift::where('statut', 'bon')->count();
        $shiftsAttention = Shift::where('statut', 'attention')->count();
        $shiftsCritiques = Shift::where('statut', 'critique')->count();
        
        // 5 derniers shifts - CORRECTION ICI
        $recentShifts = Shift::orderBy('created_at', 'desc')
                            ->orderBy('date', 'desc')
                            ->take(5)
                            ->get();
        
        return view('dashboard', compact(
            'role', 
            'totalShifts', 
            'shiftsBons', 
            'shiftsAttention', 
            'shiftsCritiques',
            'recentShifts'  // Maintenant défini
        ));
    }

    public function superviseur(){
        $recentShifts = Shift::orderBy('created_at', 'desc')->take(10)->get();
        return view('dashboard.superviseur', [
            'role'=>'superviseur',
            'recentShifts' => $recentShifts
        ]);
    }

    public function methodes(){
        $recentShifts = Shift::orderBy('created_at', 'desc')->take(10)->get();
        return view('dashboard.methodes', [
            'role'=>'methodes',
            'recentShifts' => $recentShifts
        ]);
    }

    public function shift(){
        $recentShifts = Shift::orderBy('created_at', 'desc')->take(10)->get();
        return view('dashboard.shift', [
            'role'=>'shift_leader',
            'recentShifts' => $recentShifts
        ]);
    }
}