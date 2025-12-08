@extends('layouts.app')

@section('title', 'Modifier le Type de Média')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Type de Média : {{ $typeMedia->nom_media }}
                    </h3>
                </div>
                <form action="{{ route('type-medias.update', $typeMedia) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_media">Nom du type de média *</label>
                            <input type="text" 
                                   class="form-control @error('nom_media') is-invalid @enderror" 
                                   id="nom_media" 
                                   name="nom_media" 
                                   value="{{ old('nom_media', $typeMedia->nom_media) }}"
                                   required>
                            @error('nom_media')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le type
                        </button>
                        <a href="{{ route('type-medias.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection