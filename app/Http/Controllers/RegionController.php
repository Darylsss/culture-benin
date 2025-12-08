<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Affiche la liste des régions
     */
    public function index()
    {
        $regions = Region::all();
        return view('regions.index', compact('regions'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('regions.create');
    }

    /**
     * Enregistre une nouvelle région
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions',
            'description' => 'nullable|string',
            'population' => 'nullable|integer|min:0',
            'superficie' => 'nullable|numeric|min:0',
            'localisation' => 'nullable|string|max:255'
        ]);

        Region::create($request->all());

        return redirect()->route('regions.index')
            ->with('success', 'Région créée avec succès!');
    }

    /**
     * Affiche les détails d'une région
     */
    public function show(Region $region)
    {
        return view('regions.show', compact('region'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    /**
     * Met à jour une région
     */
    public function update(Request $request, Region $region)
    {
        $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions,nom_region,' . $region->id_region . ',id_region',
            'description' => 'nullable|string',
            'population' => 'nullable|integer|min:0',
            'superficie' => 'nullable|numeric|min:0',
            'localisation' => 'nullable|string|max:255'
        ]);

        $region->update($request->all());

        return redirect()->route('regions.index')
            ->with('success', 'Région modifiée avec succès!');
    }

    /**
     * Supprime une région
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return redirect()->route('regions.index')
            ->with('success', 'Région supprimée avec succès!');
    }
}