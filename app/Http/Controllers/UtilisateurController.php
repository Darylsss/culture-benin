<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Role;
use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        $utilisateurs = Utilisateur::with('role', 'langue')->get();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $roles = Role::all();
        $langues = Langue::all();
        return view('utilisateurs.create', compact('roles', 'langues'));
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|min:6',
            'sexe' => 'required|in:homme,femme',
            'date_inscription' => 'required|date',
            'date_naissance' => 'nullable|date',
            'statut' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'id_role' => 'required|exists:roles,id_role',
            'id_langue' => 'required|exists:langues,id_langue'
        ]);

        $data = $request->all();
        $data['mot_de_passe'] = Hash::make($request->mot_de_passe);

        Utilisateur::create($data);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès!');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(Utilisateur $utilisateur)
    {
        $utilisateur->load('role', 'langue');
        return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Utilisateur $utilisateur)
    {
        $roles = Role::all();
        $langues = Langue::all();
        return view('utilisateurs.edit', compact('utilisateur', 'roles', 'langues'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id_utilisateur . ',id_utilisateur',
            'sexe' => 'required|in:homme,femme',
            'date_inscription' => 'required|date',
            'date_naissance' => 'nullable|date',
            'statut' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'id_role' => 'required|exists:roles,id_role',
            'id_langue' => 'required|exists:langues,id_langue'
        ]);

        $data = $request->except('mot_de_passe');

        // Si un nouveau mot de passe est fourni
        if ($request->filled('mot_de_passe')) {
            $request->validate([
                'mot_de_passe' => 'min:6'
            ]);
            $data['mot_de_passe'] = Hash::make($request->mot_de_passe);
        }

        $utilisateur->update($data);

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur modifié avec succès!');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès!');
    }
}