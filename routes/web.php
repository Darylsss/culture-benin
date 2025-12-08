<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\TypeMediaController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use \App\Http\Middleware\VerifyCsrfToken;


Route::resource('langues', TypeContenuController::class);
Route::resource('roles', RoleController::class);
Route::resource('regions', RegionController::class);
Route::resource('type-contenus', TypeContenuController::class);
Route::resource('type-medias', TypeMediaController::class);
Route::resource('utilisateurs', UtilisateurController::class);
Route::resource('contenus', ContenuController::class);
Route::resource('medias', MediaController::class);
Route::resource('commentaires', CommentaireController::class);




Route::get('/test-upload-form', [ContenuController::class, 'createTest']);


// Routes d'authentification
Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Routes d'inscription
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');
// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');


// Ajoutez cette route AVANT le groupe middleware admin
Route::get('/langues/datatable', [LangueController::class, 'datatable'])
    ->name('langues.datatable')
    ->middleware('auth');


// Routes accessibles à tous les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes en lecture seule pour les utilisateurs normaux
    Route::get('/langues', [LangueController::class, 'index'])->name('langues.index');
    Route::get('/langues/{langue}', [LangueController::class, 'show'])->name('langues.show');
    
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    
    Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
    Route::get('/regions/{region}', [RegionController::class, 'show'])->name('regions.show');
    
    Route::get('/type-contenus', [TypeContenuController::class, 'index'])->name('type-contenus.index');
    Route::get('/type-contenus/{type_contenu}', [TypeContenuController::class, 'show'])->name('type-contenus.show');
    
    Route::get('/type-medias', [TypeMediaController::class, 'index'])->name('type-medias.index');
    Route::get('/type-medias/{type_media}', [TypeMediaController::class, 'show'])->name('type-medias.show');
    
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::get('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'show'])->name('utilisateurs.show');
    
    Route::get('/contenus', [ContenuController::class, 'index'])->name('contenus.index');
    Route::get('/contenus/{contenu}', [ContenuController::class, 'show'])->name('contenus.show');
    
    Route::get('/medias', [MediaController::class, 'index'])->name('medias.index');
    Route::get('/medias/{media}', [MediaController::class, 'show'])->name('medias.show');
    
    Route::get('/commentaires', [CommentaireController::class, 'index'])->name('commentaires.index');
    Route::get('/commentaires/{commentaire}', [CommentaireController::class, 'show'])->name('commentaires.show');
});

// Routes ADMIN SEULEMENT (CRUD complet)
Route::middleware(['auth', 'admin'])->group(function () {
    // Routes de création, modification et suppression
    Route::get('/langues/create', [LangueController::class, 'create'])->name('langues.create');
    Route::post('/langues', [LangueController::class, 'store'])->name('langues.store');
    Route::get('/langues/{langue}/edit', [LangueController::class, 'edit'])->name('langues.edit');
    Route::put('/langues/{langue}', [LangueController::class, 'update'])->name('langues.update');
    Route::delete('/langues/{langue}', [LangueController::class, 'destroy'])->name('langues.destroy');
    
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
    Route::get('/regions/create', [RegionController::class, 'create'])->name('regions.create');
    Route::post('/regions', [RegionController::class, 'store'])->name('regions.store');
    Route::get('/regions/{region}/edit', [RegionController::class, 'edit'])->name('regions.edit');
    Route::put('/regions/{region}', [RegionController::class, 'update'])->name('regions.update');
    Route::delete('/regions/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');
    
    Route::get('/type-contenus/create', [TypeContenuController::class, 'create'])->name('type-contenus.create');
    Route::post('/type-contenus', [TypeContenuController::class, 'store'])->name('type-contenus.store');
    Route::get('/type-contenus/{type_contenu}/edit', [TypeContenuController::class, 'edit'])->name('type-contenus.edit');
    Route::put('/type-contenus/{type_contenu}', [TypeContenuController::class, 'update'])->name('type-contenus.update');
    Route::delete('/type-contenus/{type_contenu}', [TypeContenuController::class, 'destroy'])->name('type-contenus.destroy');
    
    Route::get('/type-medias/create', [TypeMediaController::class, 'create'])->name('type-medias.create');
    Route::post('/type-medias', [TypeMediaController::class, 'store'])->name('type-medias.store');
    Route::get('/type-medias/{type_media}/edit', [TypeMediaController::class, 'edit'])->name('type-medias.edit');
    Route::put('/type-medias/{type_media}', [TypeMediaController::class, 'update'])->name('type-medias.update');
    Route::delete('/type-medias/{type_media}', [TypeMediaController::class, 'destroy'])->name('type-medias.destroy');
    
    Route::get('/utilisateurs/create', [UtilisateurController::class, 'create'])->name('utilisateurs.create');
    Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
    Route::get('/utilisateurs/{utilisateur}/edit', [UtilisateurController::class, 'edit'])->name('utilisateurs.edit');
    Route::put('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'update'])->name('utilisateurs.update');
    Route::delete('/utilisateurs/{utilisateur}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');
    
    Route::get('/contenus/create', [ContenuController::class, 'create'])->name('contenus.create');
    Route::post('/contenus', [ContenuController::class, 'store'])->name('contenus.store');
    Route::get('/contenus/{contenu}/edit', [ContenuController::class, 'edit'])->name('contenus.edit');
    Route::put('/contenus/{contenu}', [ContenuController::class, 'update'])->name('contenus.update');
    Route::delete('/contenus/{contenu}', [ContenuController::class, 'destroy'])->name('contenus.destroy');
    
    Route::get('/medias/create', [MediaController::class, 'create'])->name('medias.create');
    Route::post('/medias', [MediaController::class, 'store'])->name('medias.store');
    Route::get('/medias/{media}/edit', [MediaController::class, 'edit'])->name('medias.edit');
    Route::put('/medias/{media}', [MediaController::class, 'update'])->name('medias.update');
    Route::delete('/medias/{media}', [MediaController::class, 'destroy'])->name('medias.destroy');
    
    Route::get('/commentaires/create', [CommentaireController::class, 'create'])->name('commentaires.create');
    Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::get('/commentaires/{commentaire}/edit', [CommentaireController::class, 'edit'])->name('commentaires.edit');
    Route::put('/commentaires/{commentaire}', [CommentaireController::class, 'update'])->name('commentaires.update');
    Route::delete('/commentaires/{commentaire}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');

    // Dashboard admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


Route::match(['get', 'post'], '/test-upload', function(Illuminate\Http\Request $request) {
    if ($request->isMethod('get')) {
        // Afficher le formulaire
        return '
        <form action="/test-upload" method="post" enctype="multipart/form-data">
            ' . csrf_field() . '
            <input type="file" name="images[]" multiple>
            <button>Test</button>
        </form>
        ';
    }
    
    // Traiter l'upload (POST)
    if ($request->hasFile('images')) {
        $file = $request->file('images')[0];
        $path = $file->store('test-upload', 'public');
        
        return response()->json([
            'success' => true,
            'message' => 'Fichier uploadé avec succès!',
            'path' => $path,
            'url' => asset('storage/' . $path),
            'file_info' => [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
            ]
        ]);
    }
    
    return response()->json(['error' => 'Aucun fichier'], 400);
});


Route::match(['get', 'post'], '/test-simple-upload', function(Illuminate\Http\Request $request) {
    
    if ($request->isMethod('get')) {
        // Formulaire simple GET
        return '
        <!DOCTYPE html>
        <html>
        <head><title>Test Simple</title></head>
        <body style="padding: 20px;">
            <h1>Test Upload Simple</h1>
            <form method="post" enctype="multipart/form-data">
                ' . csrf_field() . '
                <input type="file" name="images[]"><br><br>
                <button type="submit">Upload</button>
            </form>
        </body>
        </html>
        ';
    }
    
    // POST: Tester l'upload
    if ($request->hasFile('images')) {
        $file = $request->file('images')[0];
        $path = $file->store('test-simple', 'public');
        
        return response()->json([
            'success' => true,
            'message' => 'Ça marche!',
            'path' => $path,
            'url' => asset('storage/' . $path)
        ]);
    }
    
    return response()->json(['error' => 'Pas de fichier'], 400);
});

// Vos routes normales
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('contenus', ContenuController::class);
// ... autres routes

// routes/web.php
Route::match(['get', 'post'], '/test-complete', function(Illuminate\Http\Request $request) {
    
    if ($request->isMethod('get')) {
        return '
        <!DOCTYPE html>
        <html>
        <head><title>Test Complet</title></head>
        <body style="padding:20px;font-family:Arial">
            <h1>Test Upload Complet</h1>
            <form method="post" enctype="multipart/form-data">
                ' . csrf_field() . '
                
                <div style="margin:10px 0">
                    <label>Titre:</label><br>
                    <input type="text" name="titre" value="Test" required>
                </div>
                
                <div style="margin:10px 0">
                    <label>Contenu:</label><br>
                    <textarea name="texte" required>Test contenu</textarea>
                </div>
                
                <div style="margin:10px 0">
                    <label>Image:</label><br>
                    <input type="file" name="images[]" required>
                </div>
                
                <!-- Récupérer les IDs depuis la base -->
                <input type="hidden" name="date_creation" value="' . date('Y-m-d') . '">
                <input type="hidden" name="statut" value="brouillon">
                <input type="hidden" name="id_region" value="1">
                <input type="hidden" name="id_langue" value="1">
                <input type="hidden" name="id_type_contenu" value="1">
                <input type="hidden" name="id_auteur" value="1">
                <input type="hidden" name="parent_id" value="">
                <input type="hidden" name="date_validation" value="">
                <input type="hidden" name="id_moderateur" value="">
                
                <button type="submit" style="padding:10px 20px">Tester</button>
            </form>
        </body>
        </html>
        ';
    }
    
    // POST - Affiche TOUTES les informations
    echo '<h1>Résultat du Test</h1>';
    echo '<pre style="background:#f5f5f5;padding:20px;border:1px solid #ccc">';
    
    echo "=== DONNÉES REÇUES ===\n";
    echo "Méthode: " . $request->method() . "\n";
    echo "Has files: " . ($request->hasFile('images') ? 'OUI' : 'NON') . "\n\n";
    
    echo "=== DONNÉES POST ===\n";
    foreach ($request->all() as $key => $value) {
        if (!is_array($value)) {
            echo "$key: $value\n";
        }
    }
    
    if ($request->hasFile('images')) {
        echo "\n=== FICHIERS ===\n";
        foreach ($request->file('images') as $key => $file) {
            echo "Fichier $key:\n";
            echo "  Nom: " . $file->getClientOriginalName() . "\n";
            echo "  Taille: " . $file->getSize() . " bytes\n";
            echo "  Type: " . $file->getMimeType() . "\n";
            
            // Test d'upload
            try {
                echo "  Test upload...\n";
                $path = $file->store('test-direct', 'public');
                echo "  ✅ Upload réussi: $path\n";
                echo "  📁 URL: " . asset('storage/' . $path) . "\n";
                
                // Vérifiez si le fichier existe physiquement
                $fullPath = storage_path('app/public/' . $path);
                echo "  📍 Chemin physique: " . $fullPath . "\n";
                echo "  📍 Existe: " . (file_exists($fullPath) ? 'OUI' : 'NON') . "\n";
                
            } catch (Exception $e) {
                echo "  ❌ Erreur upload: " . $e->getMessage() . "\n";
            }
            echo "\n";
        }
    }
    
    echo "\n=== TEST VALIDATION MANUELLE ===\n";
    
    // Test de validation manuelle
    $validator = validator($request->all(), [
        'titre' => 'required|string|max:255',
        'texte' => 'required|string',
        'date_creation' => 'required|date',
        'statut' => 'required|string|max:255',
        'id_region' => 'required|exists:regions,id_region',
        'id_langue' => 'required|exists:langues,id_langue',
        'id_type_contenu' => 'required|exists:type_contenus,id_type_contenu',
        'id_auteur' => 'required|exists:utilisateurs,id_utilisateur',
    ]);
    
    if ($validator->fails()) {
        echo "❌ Validation échouée:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "  - $error\n";
        }
    } else {
        echo "✅ Validation réussie\n";
    }
    
    echo "</pre>";
    
    echo '<h3>Vérifications:</h3>';
    echo '<ul>';
    echo '<li><a href="/storage/test-direct" target="_blank">Voir le dossier upload</a></li>';
    echo '<li><a href="' . route('contenus.index') . '">Voir la liste des contenus</a></li>';
    echo '</ul>';
});

// Routes publiques de paiement
Route::middleware(['auth'])->group(function () {
    // Formulaire de paiement
    Route::get('/payment/{contenu}/{type?}', [PaymentController::class, 'showPaymentForm'])
        ->name('payment.form');
    
    // Traiter le paiement
    Route::post('/payment/{contenu}', [PaymentController::class, 'processPayment'])
        ->name('payment.process');
    
    // Vérifier le statut d'un paiement
    Route::get('/payment/status/{payment}', [PaymentController::class, 'checkPaymentStatus'])
        ->name('payment.status');
    
    // Historique des paiements
    Route::get('/my-payments', [PaymentController::class, 'paymentHistory'])
        ->name('payment.history');
});

// Callback FedaPay (accessible sans authentification)
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])
    ->name('payment.callback');

// Webhook FedaPay (accessible sans authentification et sans CSRF)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('payment.webhook');

           
Route::get('/test-fedapay-config', function() {
    return [
        'simulate' => config('fedapay.simulate'),
        'environment' => config('fedapay.environment'),
        'sandbox_public_key_set' => !empty(config('fedapay.sandbox.public_key')),
        'sandbox_secret_key_set' => !empty(config('fedapay.sandbox.secret_key')),
        'config_file_exists' => file_exists(config_path('fedapay.php')),
        'env_values' => [
            'FEDAPAY_SIMULATE' => env('FEDAPAY_SIMULATE'),
            'FEDAPAY_ENVIRONMENT' => env('FEDAPAY_ENVIRONMENT'),
        ]
    ];
});