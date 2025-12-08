@extends('layouts.app')

@section('title', 'Modifier le Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Contenu : {{ $contenu->titre }}
                    </h3>
                </div>
                  <form action="{{ route('contenus.store') }}" method="POST" enctype="multipart/form-data">
               @csrf
 @method('PUT')
                <!-- Votre champ d'upload DOIT s'appeler "images[]" -->
    <div class="form-group">
        <label for="images">Images</label>
        <input type="file" 
               class="form-control" 
               id="images" 
               name="images[]"       <!-- IMPORTANT: images[] -->
               multiple              <!-- Pour upload multiple -->
               accept="image/*">
    </div>
    
    <button type="submit">Créer</button>
</form>
                   
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="titre">Titre *</label>
                            <input type="text" 
                                   class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" 
                                   name="titre" 
                                   value="{{ old('titre', $contenu->titre) }}"
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
                                      required>{{ old('texte', $contenu->texte) }}</textarea>
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
                                           value="{{ old('date_creation', $contenu->date_creation) }}"
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
                                        <option value="brouillon" {{ old('statut', $contenu->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="en_attente" {{ old('statut', $contenu->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="publié" {{ old('statut', $contenu->statut) == 'publié' ? 'selected' : '' }}>Publié</option>
                                        <option value="rejeté" {{ old('statut', $contenu->statut) == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
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
                                           value="{{ old('date_validation', $contenu->date_validation) }}"
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
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id_region }}" {{ old('id_region', $contenu->id_region) == $region->id_region ? 'selected' : '' }}>
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
                                        @foreach($langues as $langue)
                                            <option value="{{ $langue->id_langue }}" {{ old('id_langue', $contenu->id_langue) == $langue->id_langue ? 'selected' : '' }}>
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
                                        @foreach($typeContenus as $type)
                                            <option value="{{ $type->id_type_contenu }}" {{ old('id_type_contenu', $contenu->id_type_contenu) == $type->id_type_contenu ? 'selected' : '' }}>
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
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_auteur', $contenu->id_auteur) == $utilisateur->id_utilisateur ? 'selected' : '' }}>
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
                                            <option value="{{ $contenuParent->id_contenu }}" {{ old('parent_id', $contenu->parent_id) == $contenuParent->id_contenu ? 'selected' : '' }}>
                                                {{ $contenuParent->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_moderateur">Modérateur</label>
                                    <select name="id_moderateur" class="form-control @error('id_moderateur') is-invalid @enderror">
                                        <option value="">Aucun modérateur</option>
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_moderateur', $contenu->id_moderateur) == $utilisateur->id_utilisateur ? 'selected' : '' }}>
                                                {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_moderateur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le contenu
                        </button>
                        <a href="{{ route('contenus.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Images existantes</label>
    @if($contenu->medias->count() > 0)
    <div class="row">
        @foreach($contenu->medias as $media)
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{ asset($media->chemin) }}" 
                     class="card-img-top" 
                     alt="Image {{ $loop->iteration }}"
                     style="height: 120px; object-fit: cover;">
                <div class="card-body p-2">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="delete_images[]" 
                               value="{{ $media->id_media }}"
                               id="delete_image_{{ $media->id_media }}">
                        <label class="form-check-label text-danger" 
                               for="delete_image_{{ $media->id_media }}">
                            Supprimer
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-muted">Aucune image</p>
    @endif
</div>

<!-- Section Images existantes -->
                        <div class="form-group">
                            <label>Images existantes</label>
                            @if($contenu->medias->count() > 0)
                            <div class="row">
                                @foreach($contenu->medias as $media)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="{{ Storage::url($media->chemin) }}" 
                                             class="card-img-top" 
                                             alt="Image {{ $loop->iteration }}"
                                             style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="delete_images[]" 
                                                       value="{{ $media->id_media }}"
                                                       id="delete_image_{{ $media->id_media }}">
                                                <label class="form-check-label text-danger" 
                                                       for="delete_image_{{ $media->id_media }}">
                                                    Supprimer
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-muted">Aucune image</p>
                            @endif
                        </div>

                        <!-- Section Nouvelle images -->
                        <div class="form-group">
                            <label for="images">Ajouter de nouvelles images</label>
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
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le contenu
                        </button>
                        <a href="{{ route('contenus.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Même script que pour create.blade.php
</script>
@endpush
@endsection