<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superviseur(){
        return view('dashboard.superviseur', ['role'=>'superviseur']);
    }

    public function methodes(){
        return view('dashboard.methodes', ['role'=>'methodes']);
    }

    public function shift(){
        return view('dashboard.shift', ['role'=>'shift_leader']);
    }
}