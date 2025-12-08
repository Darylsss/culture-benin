@extends('layouts.app')

@section('title', 'Créer un Type de Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouveau Type de Contenu
                    </h3>
                </div>
                <form action="{{ route('type-contenus.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_contenu">Nom du type de contenu *</label>
                            <input type="text" 
                                   class="form-control @error('nom_contenu') is-invalid @enderror" 
                                   id="nom_contenu" 
                                   name="nom_contenu" 
                                   value="{{ old('nom_contenu') }}"
                                   placeholder="Ex: Article, Vidéo, Photo, Audio..."
                                   required>
                            @error('nom_contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Le nom du type de contenu doit être unique
                            </small>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer le type
                        </button>
                        <a href="{{ route('type-contenus.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection