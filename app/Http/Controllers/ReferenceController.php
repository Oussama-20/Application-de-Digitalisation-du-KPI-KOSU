<?php
// app/Http/Controllers/ReferenceController.php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Afficher la liste des références
     */
    public function index()
    {
        $references = Reference::orderBy('created_at', 'desc')->get();
        return view('references.index', compact('references'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('references.create');
    }

    /**
     * Enregistrer une nouvelle référence
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:references,reference|max:50',
            'name' => 'nullable|string|max:255',
            'coefficient' => 'required|numeric|min:0|max:9999.99',
            'description' => 'nullable|string'
        ]);

        // Ajouter created_by par défaut
        $validated['created_by'] = 'ME001'; // Vous pouvez changer selon l'utilisateur connecté

        Reference::create($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence créée avec succès!');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Reference $reference)
    {
        return view('references.edit', compact('reference'));
    }

    /**
     * Mettre à jour une référence
     */
    public function update(Request $request, Reference $reference)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:50|unique:references,reference,' . $reference->id,
            'name' => 'nullable|string|max:255',
            'coefficient' => 'required|numeric|min:0|max:9999.99',
            'description' => 'nullable|string'
        ]);

        $reference->update($validated);

        return redirect()->route('references.index')
            ->with('success', 'Référence mise à jour avec succès!');
    }

    /**
     * Supprimer une référence
     */
    public function destroy(Reference $reference)
    {
        $reference->delete();

        return redirect()->route('references.index')
            ->with('success', 'Référence supprimée avec succès!');
    }
}