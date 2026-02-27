<?php
namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\ShiftDetail;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function create()
    {
       

        $references = Reference::all(); // pour alimenter la liste déroulante des références
        return view('shifts.create', compact('references'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'team_speaker' => 'nullable|string|max:255',
            'supervisor' => 'nullable|string|max:255',
            'line' => 'required|string|max:10',
            'details' => 'required|array|min:1',
            'details.*.hour' => 'required|date_format:H:i',
            'details.*.planned_operators' => 'nullable|integer|min:0',
            'details.*.present_operators' => 'nullable|integer|min:0',
            'details.*.net_time' => 'nullable|numeric|min:0',
            'details.*.reference' => 'nullable|string|max:255',
            'details.*.coefficient' => 'nullable|numeric|min:0',
            'details.*.objective_quantity' => 'nullable|integer|min:0',
            'details.*.good_quantity' => 'nullable|integer|min:0',
            'details.*.bad_quantity' => 'nullable|integer|min:0',
            'details.*.comments' => 'nullable|string',
        ]);

        $shift = Shift::create([
            'date' => $request->date,
            'team_speaker' => $request->team_speaker,
            'supervisor' => $request->supervisor,
            'line' => $request->line,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->details as $detailData) {
            // Calcul du KOSU réel
            $kosuReal = null;
            if (($detailData['good_quantity'] ?? 0) > 0 && ($detailData['coefficient'] ?? 0) > 0) {
                $present = $detailData['present_operators'] ?? 0;
                $net = $detailData['net_time'] ?? 0;
                $good = $detailData['good_quantity'];
                $coeff = $detailData['coefficient'];
                $kosuReal = round(($present * $net) / ($good * $coeff), 2);
            }

            $shift->details()->create([
                'hour' => $detailData['hour'],
                'planned_operators' => $detailData['planned_operators'] ?? 0,
                'present_operators' => $detailData['present_operators'] ?? 0,
                'net_time' => $detailData['net_time'] ?? 0,
                'reference' => $detailData['reference'] ?? null,
                'coefficient' => $detailData['coefficient'] ?? 1,
                'objective_quantity' => $detailData['objective_quantity'] ?? 0,
                'good_quantity' => $detailData['good_quantity'] ?? 0,
                'bad_quantity' => $detailData['bad_quantity'] ?? 0,
                'kosu_real' => $kosuReal,
                'comments' => $detailData['comments'] ?? null,
            ]);
        }

        return redirect()->route('shifts.index')->with('success', 'Shift enregistré avec succès.');
    }

    public function index()
    {
        $shifts = Shift::with('user')->latest()->paginate(20);
        return view('shifts.index', compact('shifts'));
    }

    public function show(Shift $shift)
    {
        // Affichage détaillé d'un shift (pour supervision)
        return view('shifts.show', compact('shift'));
    }
}