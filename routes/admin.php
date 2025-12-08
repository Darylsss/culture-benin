<?php 
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

// Routes pour les langues
Route::resource('langues', LangueController::class);

Route::resource('roles', RoleController::class);

Route::resource('regions', RegionController::class);

Route::resource('type-contenus', TypeContenuController::class);

Route::resource('type-medias', TypeMediaController::class);

Route::resource('utilisateurs', UtilisateurController::class);

Route::resource('contenus', ContenuController::class);

Route::resource('medias', MediaController::class);

Route::resource('commentaires', CommentaireController::class);




// Route dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', function () {
    return redirect('/dashboard');
});

