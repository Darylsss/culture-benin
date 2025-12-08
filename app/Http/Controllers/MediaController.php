<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Contenu;
use App\Models\TypeMedia;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Affiche la liste des médias
     */
    public function index()
    {
        $medias = Media::with(['contenu', 'typeMedia'])->get();
        return view('medias.index', compact('medias'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $contenus = Contenu::all();
        $typeMedias = TypeMedia::all();
        return view('medias.create', compact('contenus', 'typeMedias'));
    }

    /**
     * Enregistre un nouveau média
     */
    public function store(Request $request)
    {
        $request->validate([
            'chemin' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_contenu' => 'required|exists:contenus,id_contenu',
            'id_type_media' => 'required|exists:type_medias,id_type_media'
        ]);

        Media::create($request->all());

        return redirect()->route('medias.index')
            ->with('success', 'Média créé avec succès!');
    }

    /**
     * Affiche les détails d'un média
     */
    public function show(Media $media)
    {
        $media->load(['contenu', 'typeMedia']);
        return view('medias.show', compact('media'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Media $media)
    {
        $contenus = Contenu::all();
        $typeMedias = TypeMedia::all();
        return view('medias.edit', compact('media', 'contenus', 'typeMedias'));
    }

    /**
     * Met à jour un média
     */
    public function update(Request $request, Media $media)
    {
        $request->validate([
            'chemin' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_contenu' => 'required|exists:contenus,id_contenu',
            'id_type_media' => 'required|exists:type_medias,id_type_media'
        ]);

        $media->update($request->all());

        return redirect()->route('medias.index')
            ->with('success', 'Média modifié avec succès!');
    }

    /**
     * Supprime un média
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return redirect()->route('medias.index')
            ->with('success', 'Média supprimé avec succès!');
    }
}