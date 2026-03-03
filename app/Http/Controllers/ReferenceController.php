<?php
namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index()
    {
        $references = Reference::orderBy('created_at', 'desc')->get();
        return view('references.index', compact('references'));
    }

    public function create()
    {
        return view('references.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references,reference|max:50',
            'name' => 'nullable|string|max:255',
            'coefficient' => 'required|numeric|min:0|max:9999.99',
            'ost' => 'required|numeric|min:0|max:9999.99',
            'kosu_objectif' => 'required|numeric|min:0|max:9999.99',
            'description' => 'nullable|string'
        ]);

        $validated['created_by'] = 'ME001';

        Reference::create($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence créée avec succès!');
    }

    public function edit(Reference $reference)
    {
        return view('references.edit', compact('reference'));
    }

    public function update(Request $request, Reference $reference)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:50|unique:references,reference,' . $reference->id,
            'name' => 'nullable|string|max:255',
            'coefficient' => 'required|numeric|min:0|max:9999.99',
            'ost' => 'required|numeric|min:0|max:9999.99',
            'kosu_objectif' => 'required|numeric|min:0|max:9999.99',
            'description' => 'nullable|string'
        ]);

        $reference->update($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence mise à jour avec succès!');
    }

    public function destroy(Reference $reference)
    {
        $reference->delete();
        return redirect()->route('references.index')
            ->with('success', 'Référence supprimée avec succès!');
    }
}