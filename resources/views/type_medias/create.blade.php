@extends('layouts.app')

@section('title', 'Créer un Type de Média')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouveau Type de Média
                    </h3>
                </div>
                <form action="{{ route('type-medias.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_media">Nom du type de média *</label>
                            <input type="text" 
                                   class="form-control @error('nom_media') is-invalid @enderror" 
                                   id="nom_media" 
                                   name="nom_media" 
                                   value="{{ old('nom_media') }}"
                                   placeholder="Ex: Image, Vidéo, Audio, Document..."
                                   required>
                            @error('nom_media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Le nom du type de média doit être unique
                            </small>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer le type
                        </button>
                        <a href="{{ route('type-medias.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection