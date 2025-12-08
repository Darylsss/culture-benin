<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Affiche la liste des rôles
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Enregistre un nouveau rôle
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_role' => 'required|string|max:255|unique:roles'
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Rôle créé avec succès!');
    }

    /**
     * Affiche les détails d'un rôle
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Met à jour un rôle
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nom_role' => 'required|string|max:255|unique:roles,nom_role,' . $role->id_role . ',id_role'
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Rôle modifié avec succès!');
    }

    /**
     * Supprime un rôle
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Rôle supprimé avec succès!');
    }
}