<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Utilisateur;
use App\Models\Contenu;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    /**
     * Affiche la liste des commentaires
     */
    public function index()
    {
        $commentaires = Commentaire::with(['utilisateur', 'contenu'])->get();
        return view('commentaires.index', compact('commentaires'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $utilisateurs = Utilisateur::all();
        $contenus = Contenu::all();
        return view('commentaires.create', compact('utilisateurs', 'contenus'));
    }

    /**
     * Enregistre un nouveau commentaire
     */
    public function store(Request $request)
    {
        $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:1|max:5',
            'date' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateurs,id_utilisateur',
            'id_contenu' => 'required|exists:contenus,id_contenu'
        ]);

        Commentaire::create($request->all());

        return redirect()->route('commentaires.index')
            ->with('success', 'Commentaire créé avec succès!');
    }

    /**
     * Affiche les détails d'un commentaire
     */
    public function show(Commentaire $commentaire)
    {
        $commentaire->load(['utilisateur', 'contenu']);
        return view('commentaires.show', compact('commentaire'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Commentaire $commentaire)
    {
        $utilisateurs = Utilisateur::all();
        $contenus = Contenu::all();
        return view('commentaires.edit', compact('commentaire', 'utilisateurs', 'contenus'));
    }

    /**
     * Met à jour un commentaire
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:1|max:5',
            'date' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateurs,id_utilisateur',
            'id_contenu' => 'required|exists:contenus,id_contenu'
        ]);

        $commentaire->update($request->all());

        return redirect()->route('commentaires.index')
            ->with('success', 'Commentaire modifié avec succès!');
    }

    /**
     * Supprime un commentaire
     */
    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();

        return redirect()->route('commentaires.index')
            ->with('success', 'Commentaire supprimé avec succès!');
    }
}