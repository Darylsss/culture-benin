@extends('layouts.app')

@section('title', 'Modifier le Commentaire')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Commentaire
                    </h3>
                </div>
                <form action="{{ route('commentaires.update', $commentaire) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="texte">Commentaire *</label>
                            <textarea class="form-control @error('texte') is-invalid @enderror" 
                                      id="texte" 
                                      name="texte" 
                                      rows="4"
                                      required>{{ old('texte', $commentaire->texte) }}</textarea>
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
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('note', $commentaire->note) == $i ? 'selected' : '' }}>
                                                @for($j = 1; $j <= $i; $j++)⭐@endfor ({{ $i }}/5)
                                            </option>
                                        @endfor
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
                                           value="{{ old('date', $commentaire->date) }}"
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
                                        @foreach($utilisateurs as $utilisateur)
                                            <option value="{{ $utilisateur->id_utilisateur }}" {{ old('id_utilisateur', $commentaire->id_utilisateur) == $utilisateur->id_utilisateur ? 'selected' : '' }}>
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
                                        @foreach($contenus as $contenu)
                                            <option value="{{ $contenu->id_contenu }}" {{ old('id_contenu', $commentaire->id_contenu) == $contenu->id_contenu ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le commentaire
                        </button>
                        <a href="{{ route('commentaires.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection