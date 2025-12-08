@extends('layouts.app')

@section('title', 'Créer un Commentaire')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouveau Commentaire
                    </h3>
                </div>
                <form action="{{ route('commentaires.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="texte">Commentaire *</label>
                            <textarea class="form-control @error('texte') is-invalid @enderror" 
                                      id="texte" 
                                      name="texte" 
                                      rows="4"
                                      placeholder="Rédigez votre commentaire ici..."
                                      required>{{ old('texte') }}</textarea>
                            @error('texte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="note">Note (optionnelle)</label>
                                    <select name="note" class="form-control @error('note') is-invalid @enderror">
                                        <option value="">Aucune note</option>
                                        <option value="1" {{ old('note') == '1' ? 'selected' : '' }}>⭐ (1/5)</option>
                                        <option value="2" {{ old('note') == '2' ? 'selected' : '' }}>⭐⭐ (2/5)</option>
                                        <option value="3" {{ old('note') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3/5)</option>
                                        <option value="4" {{ old('note') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4/5)</option>
                                        <option value="5" {{ old('note') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5/5)</option>
                                    </select>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date *</label>
                                    <input type="date" 
                                           class="form-control @error('date') is-invalid @enderror" 
                                           id="date" 
                                           name="date" 
                                           value="{{ old('date', date('Y-m-d')) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_utilisateur">Utilisateur *</label>
                                    <select name="id_utilisateur" class="form-control @error('id_utilisateur') is-invalid @enderror" required>
                                        <option value="">Sélectionner un utilisateur</option>
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_utilisateur') == $utilisateur->id_utilisateur ? 'selected' : '' }}>
                                                {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_utilisateur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_contenu">Contenu *</label>
                                    <select name="id_contenu" class="form-control @error('id_contenu') is-invalid @enderror" required>
                                        <option value="">Sélectionner un contenu</option>
                                        @foreach($contenus as $contenu)
                                            <option value="{{ $contenu->id_contenu }}" {{ old('id_contenu') == $contenu->id_contenu ? 'selected' : '' }}>
                                                {{ $contenu->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer le commentaire
                        </button>
                        <a href="{{ route('commentaires.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection