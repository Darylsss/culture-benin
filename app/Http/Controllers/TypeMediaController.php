<?php

namespace App\Http\Controllers;

use App\Models\TypeMedia;
use Illuminate\Http\Request;

class TypeMediaController extends Controller
{
    /**
     * Affiche la liste des types de média
     */
    public function index()
    {
        $typeMedias = TypeMedia::all();
        return view('type_medias.index', compact('typeMedias'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('type_medias.create');
    }

    /**
     * Enregistre un nouveau type de média
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_media' => 'required|string|max:255|unique:type_medias'
        ]);

        TypeMedia::create($request->all());

        return redirect()->route('type-medias.index')
            ->with('success', 'Type de média créé avec succès!');
    }

    /**
     * Affiche les détails d'un type de média
     */
    public function show(TypeMedia $typeMedia)
    {
        return view('type_medias.show', compact('typeMedia'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(TypeMedia $typeMedia)
    {
        return view('type_medias.edit', compact('typeMedia'));
    }

    /**
     * Met à jour un type de média
     */
    public function update(Request $request, TypeMedia $typeMedia)
    {
        $request->validate([
            'nom_media' => 'required|string|max:255|unique:type_medias,nom_media,' . $typeMedia->id_type_media . ',id_type_media'
        ]);

        $typeMedia->update($request->all());

        return redirect()->route('type-medias.index')
            ->with('success', 'Type de média modifié avec succès!');
    }

    /**
     * Supprime un type de média
     */
    public function destroy(TypeMedia $typeMedia)
    {
        $typeMedia->delete();

        return redirect()->route('type-medias.index')
            ->with('success', 'Type de média supprimé avec succès!');
    }
}