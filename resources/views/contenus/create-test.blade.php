{{-- resources/views/contenus/create-test.blade.php --}}
@extends('layouts.app')

@section('title', 'Test Upload')

@section('content')
<div class="container">
    <h1>Test Formulaire Contenu</h1>
    
    <div class="alert alert-info">
        <strong>Rappel :</strong> Le test simple fonctionne ✅<br>
        Testons maintenant avec le même formulaire structure.
    </div>
    
    <!-- FORMULAIRE SIMPLIFIÉ -->
    <form action="{{ route('contenus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Champ OBLIGATOIRE pour debug -->
        <input type="hidden" name="debug" value="test">
        
        <!-- 1-2 champs seulement pour tester -->
        <div class="form-group">
            <label>Titre *</label>
            <input type="text" 
                   name="titre" 
                   class="form-control" 
                   value="Test Upload Form" 
                   required>
        </div>
        
        <div class="form-group">
            <label>Contenu *</label>
            <textarea name="texte" class="form-control" required>Test contenu...</textarea>
        </div>
        
        <!-- IMAGES - LE PLUS IMPORTANT -->
        <div class="form-group">
            <label>Images *</label>
            <input type="file" 
                   name="images[]" 
                   class="form-control" 
                   multiple
                   required>
            <small class="text-muted">Choisissez 1 image pour tester</small>
        </div>
        
        <!-- Champs cachés requis par la validation -->
        <input type="hidden" name="date_creation" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="statut" value="brouillon">
        <input type="hidden" name="id_region" value="1">
        <input type="hidden" name="id_langue" value="1">
        <input type="hidden" name="id_type_contenu" value="1">
        <input type="hidden" name="id_auteur" value="1">
        
        <button type="submit" class="btn btn-primary">
            Tester l'Upload
        </button>
        
        <a href="{{ route('contenus.create') }}" class="btn btn-secondary">
            Retour au formulaire réel
        </a>
    </form>
    
    <hr>
    
    <div class="card">
        <div class="card-header">Debug Info</div>
        <div class="card-body">
            <h5>Formulaire actuel :</h5>
            <ul>
                <li>Action: {{ route('contenus.store') }}</li>
                <li>Méthode: POST</li>
                <li>enctype: multipart/form-data ✅</li>
                <li>name="images[]" ✅</li>
            </ul>
            
            <h5>À vérifier :</h5>
            <ol>
                <li>Cliquez "Tester l'Upload"</li>
                <li>Vérifiez les logs Laravel</li>
                <li>Vérifiez le dossier storage/app/public/contenus/</li>
            </ol>
        </div>
    </div>
</div>
@endsection