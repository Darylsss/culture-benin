<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\TypeContenu;
use App\Models\Utilisateur;
use App\Models\Media;
use App\Models\TypeMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContenuController extends Controller
{
    /**
     * Affiche la liste des contenus
     */
    public function index()
    {
        $contenus = Contenu::with(['region', 'langue', 'typeContenu', 'auteur', 'moderateur', 'parent'])
                          ->get();
        return view('contenus.index', compact('contenus'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $regions = Region::all();
        $langues = Langue::all();
        $typeContenus = TypeContenu::all();
        $utilisateurs = Utilisateur::all();
        $contenusParents = Contenu::all();

        // Valeurs par défaut sélectionnées
        $defaultRegion = $regions->first();
        $defaultLangue = $langues->first();
        $defaultType = $typeContenus->first();
        $defaultUser = $utilisateurs->first();
        
        return view('contenus.create', compact(
            'regions', 
            'langues', 
            'typeContenus', 
            'utilisateurs',
            'contenusParents'
        ));
    }

    /**
     * Enregistre un nouveau contenu
     */
    public function store(Request $request)
    {
        // DEBUG: Vérifiez CE QUI BLOQUE
        Log::info('=== DÉBUT STORE ===');
        Log::info('Has files: ' . ($request->hasFile('images') ? 'OUI' : 'NON'));
        Log::info('All input keys: ' . implode(', ', array_keys($request->all())));
        
        // Affichez toutes les données (sauf fichiers)
        foreach ($request->all() as $key => $value) {
            if ($key !== 'images') {
                Log::info("$key: $value");
            }
        }
        
        try {
            // Validation
            Log::info('=== AVANT VALIDATION ===');
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'texte' => 'required|string',
                'date_creation' => 'required|date',
                'statut' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:contenus,id_contenu',
                'date_validation' => 'nullable|date',
                'id_region' => 'required|exists:regions,id_region',
                'id_langue' => 'required|exists:langues,id_langue',
                'id_moderateur' => 'nullable|exists:utilisateurs,id_utilisateur',
                'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
                'id_auteur' => 'required|exists:utilisateurs,id_utilisateur',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);
            
            Log::info('=== VALIDATION RÉUSSIE ===');
            
            // Créer le contenu
            $contenu = Contenu::create($validated);
            Log::info('Contenu créé ID: ' . $contenu->id_contenu);
            
            // Upload des images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadImage($image, $contenu);
                    Log::info('Image uploadée: ' . $path);
                }
            }
            
            Log::info('=== STORE TERMINÉ AVEC SUCCÈS ===');
            
            return redirect()->route('contenus.index')
                ->with('success', 'Contenu créé avec succès!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('=== ERREUR VALIDATION ===');
            Log::error($e->getMessage());
            Log::error('Errors: ' . json_encode($e->errors()));
            throw $e; // Laravel gère la redirection
            
        } catch (\Exception $e) {
            Log::error('=== ERREUR GÉNÉRALE ===');
            Log::error($e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un contenu
     */
   
    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Contenu $contenu)
    {
        $regions = Region::all();
        $langues = Langue::all();
        $typeContenus = TypeContenu::all();
        $utilisateurs = Utilisateur::all();
        $contenusParents = Contenu::where('id_contenu', '!=', $contenu->id_contenu)->get();
        
        return view('contenus.edit', compact(
            'contenu',
            'regions', 
            'langues', 
            'typeContenus', 
            'utilisateurs',
            'contenusParents'
        ));
    }

    /**
     * Met à jour un contenu
     */
    public function update(Request $request, Contenu $contenu)
    {
        // DEBUG
        Log::info('=== UPDATE CONTENU ID: ' . $contenu->id_contenu . ' ===');
        Log::info('Has files: ' . ($request->hasFile('images') ? 'OUI' : 'NON'));
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'date_creation' => 'required|date',
            'statut' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:contenus,id_contenu',
            'date_validation' => 'nullable|date',
            'id_region' => 'required|exists:regions,id_region',
            'id_langue' => 'required|exists:langues,id_langue',
            'id_moderateur' => 'nullable|exists:utilisateurs,id_utilisateur',
            'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
            'id_auteur' => 'required|exists:utilisateurs,id_utilisateur',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:medias,id_media',
        ]);

        DB::beginTransaction();
        
        try {
            // Mettre à jour le contenu
            $contenu->update($request->except(['images', 'delete_images']));
            
            // Supprimer les images sélectionnées
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $mediaId) {
                    $media = Media::find($mediaId);
                    if ($media) {
                        // Supprimer le fichier physique
                        if (Storage::disk('public')->exists(str_replace('storage/', '', $media->chemin))) {
                            Storage::disk('public')->delete(str_replace('storage/', '', $media->chemin));
                        }
                        // Supprimer l'enregistrement en base
                        $media->delete();
                        Log::info('Image supprimée ID: ' . $mediaId);
                    }
                }
            }
            
            // Upload des nouvelles images
            if ($request->hasFile('images')) {
                $uploadedCount = 0;
                
                foreach ($request->file('images') as $image) {
                    $path = $this->uploadImage($image, $contenu);
                    Log::info('Nouvelle image uploadée: ' . $path);
                    $uploadedCount++;
                }
                
                Log::info($uploadedCount . ' nouvelles images uploadées');
            }
            
            DB::commit();
            
            return redirect()->route('contenus.index')
                ->with('success', 'Contenu modifié avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur modification contenu: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Erreur lors de la modification du contenu: ' . $e->getMessage());
        }
    }

    /**
     * Supprime un contenu
     */
    public function destroy(Contenu $contenu)
    {
        DB::beginTransaction();
        
        try {
            // Supprimer les images associées
            foreach ($contenu->medias as $media) {
                // Supprimer le fichier physique
                if (Storage::disk('public')->exists(str_replace('storage/', '', $media->chemin))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $media->chemin));
                }
                // Supprimer l'enregistrement en base
                $media->delete();
            }
            
            // Supprimer le contenu
            $contenu->delete();
            
            DB::commit();
            
            return redirect()->route('contenus.index')
                ->with('success', 'Contenu supprimé avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur suppression contenu: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Erreur lors de la suppression du contenu: ' . $e->getMessage());
        }
    }

    /**
     * Upload une image - VERSION CORRIGÉE
     */
    private function uploadImage($imageFile, $contenu)
    {
        try {
            // Upload du fichier
            $path = $imageFile->store('contenus', 'public');
            
            // CORRECTION: Récupérer dynamiquement le type de média "Image"
            $typeMedia = TypeMedia::where('nom_media', 'Image')
                                  ->orWhere('nom_media', 'LIKE', '%image%')
                                  ->first();
            
            // Si aucun type "Image" n'existe, prendre le premier disponible ou créer
            if (!$typeMedia) {
                Log::warning('Aucun type média "Image" trouvé, création automatique');
                $typeMedia = TypeMedia::firstOrCreate(
                    ['nom_media' => 'Image'],
                    ['description' => 'Fichiers images']
                );
            }
            
            // Créer l'enregistrement dans la table medias
            Media::create([
                'chemin' => 'storage/' . $path,
                'id_contenu' => $contenu->id_contenu,
                'id_type_media' => $typeMedia->id_type_media, // ID dynamique
                'nom_original' => $imageFile->getClientOriginalName(),
                'description' => 'Image pour: ' . $contenu->titre,
                'taille' => $imageFile->getSize(),
                'mime_type' => $imageFile->getMimeType(),
            ]);
            
            Log::info('Image uploadée avec succès: ' . $path);
            Log::info('Type média utilisé ID: ' . $typeMedia->id_type_media);
            
            return $path;
            
        } catch (\Exception $e) {
            Log::error('Erreur upload image: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Récupère l'ID du type média - VERSION AMÉLIORÉE
     */
    private function getTypeMediaId($type)
    {
        $typeNames = [
            'image' => ['Image', 'image', 'IMG'],
            'video' => ['Vidéo', 'Video', 'video'],
            'audio' => ['Audio', 'audio', 'SON'],
            'document' => ['Document', 'document', 'DOC'],
        ];
        
        $searchNames = $typeNames[$type] ?? ['Image'];
        
        $typeMedia = TypeMedia::whereIn('nom_media', $searchNames)->first();
        
        if (!$typeMedia) {
            // Si aucun type trouvé, prendre le premier disponible
            $typeMedia = TypeMedia::first();
        }
        
        return $typeMedia ? $typeMedia->id_type_media : null;
    }

    /**
     * Supprime une image spécifique (API)
     */
    public function deleteImage(Request $request, $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        
        DB::beginTransaction();
        
        try {
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists(str_replace('storage/', '', $media->chemin))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $media->chemin));
            }
            
            // Supprimer l'enregistrement
            $media->delete();
            
            DB::commit();
            
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return back()->with('success', 'Image supprimée avec succès');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erreur suppression image: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Erreur lors de la suppression de l\'image');
        }
    }

    /**
     * Méthode de test
     */
    public function createTest()
    {
        $regions = Region::all();
        $langues = Langue::all();
        $typeContenus = TypeContenu::all();
        $utilisateurs = Utilisateur::all();
        
        return view('contenus.create-test', compact(
            'regions', 'langues', 'typeContenus', 'utilisateurs'
        ));
    }


   public function show($id)
{
    $contenu = Contenu::with(['region', 'langue', 'typeContenu', 'auteur', 'medias'])
        ->findOrFail($id);
    
    $similarContents = Contenu::where('id_type_contenu', $contenu->id_type_contenu)
        ->where('id_contenu', '!=', $id)
        ->with('medias')
        ->where('statut', 'publié')
        ->latest()
        ->take(3)
        ->get();
    
    // Détecter si c'est une requête front ou admin
    if (request()->is('admin/*') || auth()->user()?->isAdmin()) {
        // Vue backend admin
        return view('contenus.show', compact('contenu'));
    } else {
        // Vue front public
        return view('contenus.show-public', compact('contenu', 'similarContents'));
    }
}
}