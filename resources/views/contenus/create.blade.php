@extends('layouts.app')

@section('title', 'Créer un Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouveau Contenu
                    </h3>
                </div>
                
                <form action="{{ route('contenus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="titre">Titre *</label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre') }}"
                                   placeholder="Ex: Les traditions culinaires de la région..."
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="texte">Contenu *</label>
                            <textarea class="form-control @error('texte') is-invalid @enderror" 
                                      id="texte" 
                                      name="texte" 
                                      rows="6"
                                      placeholder="Rédigez votre contenu ici..."
                                      required>{{ old('texte') }}</textarea>
                            @error('texte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_creation">Date de création *</label>
                                    <input type="date" 
                                           class="form-control @error('date_creation') is-invalid @enderror" 
                                           id="date_creation" 
                                           name="date_creation" 
                                           value="{{ old('date_creation', date('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('date_creation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="statut">Statut *</label>
                                    <select name="statut" class="form-control @error('statut') is-invalid @enderror" required>
                                        <option value="">Sélectionner</option>
                                        <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="en_attente" {{ old('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="publié" {{ old('statut') == 'publié' ? 'selected' : '' }}>Publié</option>
                                        <option value="rejeté" {{ old('statut') == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                                    </select>
                                    @error('statut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_validation">Date de validation</label>
                                    <input type="date" 
                                           class="form-control @error('date_validation') is-invalid @enderror" 
                                           id="date_validation" 
                                           name="date_validation" 
                                           value="{{ old('date_validation') }}"
                                           max="{{ date('Y-m-d') }}">
                                    @error('date_validation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_region">Région *</label>
                                    <select name="id_region" class="form-control @error('id_region') is-invalid @enderror" required>
                                        <option value="">Sélectionner une région</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id_region }}" {{ old('id_region') == $region->id_region ? 'selected' : '' }}>
                                                {{ $region->nom_region }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_langue">Langue *</label>
                                    <select name="id_langue" class="form-control @error('id_langue') is-invalid @enderror" required>
                                        <option value="">Sélectionner une langue</option>
                                        @foreach($langues as $langue)
                                            <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                                                {{ $langue->nom_langue }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_type_contenu">Type de contenu *</label>
                                    <select name="id_type_contenu" class="form-control @error('id_type_contenu') is-invalid @enderror" required>
                                        <option value="">Sélectionner un type</option>
                                        @foreach($typeContenus as $type)
                                            <option value="{{ $type->id_type_contenu }}" {{ old('id_type_contenu') == $type->id_type_contenu ? 'selected' : '' }}>
                                                {{ $type->nom_contenu }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_type_contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_auteur">Auteur *</label>
                                    <select name="id_auteur" class="form-control @error('id_auteur') is-invalid @enderror" required>
                                        <option value="">Sélectionner un auteur</option>
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_auteur') == $utilisateur->id_utilisateur ? 'selected' : '' }}>
                                                {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_auteur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_id">Contenu parent</label>
                                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                        <option value="">Aucun (contenu principal)</option>
                                        @foreach($contenusParents as $contenuParent)
                                            <option value="{{ $contenuParent->id_contenu }}" {{ old('parent_id') == $contenuParent->id_contenu ? 'selected' : '' }}>
                                                {{ $contenuParent->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Sélectionnez un contenu parent si ce contenu est une réponse ou une suite
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_moderateur">Modérateur</label>
                                    <select name="id_moderateur" class="form-control @error('id_moderateur') is-invalid @enderror">
                                        <option value="">Aucun modérateur</option>
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_moderateur') == $utilisateur->id_utilisateur ? 'selected' : '' }}>
                                                {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_moderateur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section Upload Images -->
                        <div class="form-group">
                            <label for="images">Images (max 5)</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('images.*') is-invalid @enderror" 
                                       id="images" 
                                       name="images[]" 
                                       multiple
                                       accept="image/*">
                                <label class="custom-file-label" for="images">Choisir des images...</label>
                            </div>
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Formats acceptés: JPG, PNG, GIF, WebP. Max 2MB par image.
                            </small>
                            
                            <!-- Prévisualisation en temps réel -->
                            <div class="image-preview mt-3" id="imagePreview"></div>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer le contenu
                        </button>
                        <a href="{{ route('contenus.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prévisualisation des images
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('images');
    const preview = document.getElementById('imagePreview');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            preview.innerHTML = '';
            
            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'd-inline-block mr-2 mb-2';
                        div.innerHTML = `
                            <div class="position-relative" style="width: 100px; height: 100px;">
                                <img src="${e.target.result}" 
                                     class="img-thumbnail" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute" 
                                        style="top: 5px; right: 5px;"
                                        onclick="this.closest('.d-inline-block').remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                        preview.appendChild(div);
                    };
                    
                    reader.readAsDataURL(file);
                }
            }
        });
    }
    
    // Mise à jour du label du fichier
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function(e) {
            let label = this.nextElementSibling;
            let files = Array.from(this.files).map(f => f.name);
            
            if (files.length === 0) {
                label.textContent = 'Choisir des images...';
            } else if (files.length === 1) {
                label.textContent = files[0];
            } else {
                label.textContent = files.length + ' images sélectionnées';
            }
        });
    });
});
</script>
@endpush

@endsection