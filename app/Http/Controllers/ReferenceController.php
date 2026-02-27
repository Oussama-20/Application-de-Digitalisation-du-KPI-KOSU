<?php
namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function index()
    {
        $references = Reference::all();
        return view('references.index', compact('references'));
    }

    public function create()
    {
        return view('references.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:references',
            'coefficient' => 'required|numeric|min:0',
        ]);
        Reference::create($request->all());
        return redirect()->route('references.index')->with('success', 'Référence créée.');
    }

    // edit, update, destroy...
}