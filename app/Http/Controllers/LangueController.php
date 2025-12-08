<?php

namespace App\Http\Controllers;

use App\Models\Langue;
use Illuminate\Http\Request;

class LangueController extends Controller
{
    public function index()
    {
        $langues = Langue::all();
        return view('langues.index', compact('langues'));
    }

    public function datatable()
{
    $langues = Langue::select(['id_langue', 'nom_langue', 'code_langue']);
    
    return datatables()->eloquent($langues)
        ->addColumn('actions', function($langue) {
            return view('langues.actions', compact('langue'));
        })
        ->rawColumns(['actions'])
        ->toJson();
}

    public function create()
    {
        return view('langues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:10|unique:langues',
            'description' => 'nullable|string'
        ]);

        Langue::create($request->all());

        return redirect()->route('langues.index')
            ->with('success', 'Langue créée avec succès!');
    }

    public function show($id)
    {
        $langue = Langue::findOrFail($id);
        return view('langues.show', compact('langue'));
    }

    public function edit($id)
    {
        $langue = Langue::findOrFail($id);
        return view('langues.edit', compact('langue'));
    }

    public function update(Request $request, $id)
    {
        $langue = Langue::findOrFail($id);
        
        $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:10|unique:langues,code_langue,' . $id . ',id_langue',
            'description' => 'nullable|string'
        ]);

        $langue->update($request->all());

        return redirect()->route('langues.index')
            ->with('success', 'Langue modifiée avec succès!');
    }

    public function destroy($id)
    {
        $langue = Langue::findOrFail($id);
        $langue->delete();

        return redirect()->route('langues.index')
            ->with('success', 'Langue supprimée avec succès!');
    }
}