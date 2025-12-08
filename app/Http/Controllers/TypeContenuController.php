<?php

namespace App\Http\Controllers;

use App\Models\TypeContenu;
use Illuminate\Http\Request;

class TypeContenuController extends Controller
{
    /**
     * Affiche la liste des types de contenu
     */
    public function index()
    {
        $typeContenus = TypeContenu::all();
        return view('type_contenus.index', compact('typeContenus'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('type_contenus.create');
    }

    /**
     * Enregistre un nouveau type de contenu
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus'
        ]);

        TypeContenu::create($request->all());

        return redirect()->route('type-contenus.index')
            ->with('success', 'Type de contenu créé avec succès!');
    }

    /**
     * Affiche les détails d'un type de contenu
     */
    public function show(TypeContenu $typeContenu)
    {
        return view('type_contenus.show', compact('typeContenu'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(TypeContenu $typeContenu)
    {
        return view('type_contenus.edit', compact('typeContenu'));
    }

    /**
     * Met à jour un type de contenu
     */
    public function update(Request $request, TypeContenu $typeContenu)
    {
        $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus,nom_contenu,' . $typeContenu->id_type_contenu . ',id_type_contenu'
        ]);

        $typeContenu->update($request->all());

        return redirect()->route('type-contenus.index')
            ->with('success', 'Type de contenu modifié avec succès!');
    }

    /**
     * Supprime un type de contenu
     */
    public function destroy(TypeContenu $typeContenu)
    {
        $typeContenu->delete();

        return redirect()->route('type-contenus.index')
            ->with('success', 'Type de contenu supprimé avec succès!');
    }
}