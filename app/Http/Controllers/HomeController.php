<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenu;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les derniers contenus publiés
        $recentContents = Contenu::with(['region', 'langue', 'typeContenu', 'auteur', 'medias'])
            ->where('statut', 'publié')
            ->orderBy('date_creation', 'desc')
            ->take(8)
            ->get();

        return view('front', compact('recentContents'));
    }
}