<?php
// app/Http/Controllers/ReferenceController.php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index()
    {
        $references = Reference::latest()->get();
        return view('references.index', compact('references'));
    }

    public function create()
    {
        return view('references.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references',
            'coefficient' => 'required|numeric|min:0',
            'ost' => 'required|numeric|min:0',
            'kosu_objectif' => 'required|numeric|min:0',
            'pourcentage_15' => 'required|numeric|min:0',
            'pourcentage_25' => 'required|numeric|min:0',
            'pourcentage_35' => 'required|numeric|min:0',
        ]);

        $validated['created_by'] = 'METHODES';
        
        Reference::create($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence créée avec succès.');
    }

    public function edit(Reference $reference)
    {
        return view('references.edit', compact('reference'));
    }

    public function update(Request $request, Reference $reference)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references,reference,' . $reference->id,
            'coefficient' => 'required|numeric|min:0',
            'ost' => 'required|numeric|min:0',
            'kosu_objectif' => 'required|numeric|min:0',
            'pourcentage_15' => 'required|numeric|min:0',
            'pourcentage_25' => 'required|numeric|min:0',
            'pourcentage_35' => 'required|numeric|min:0',
        ]);

        $reference->update($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence mise à jour avec succès.');
    }

    public function destroy(Reference $reference)
    {
        $reference->delete();

        return redirect()->route('references.index')
            ->with('success', 'Référence supprimée avec succès.');
    }
}