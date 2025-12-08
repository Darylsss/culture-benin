@extends('layouts.app')

@section('title', 'Modifier le Média')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Média
                    </h3>
                </div>
                <form action="{{ route('medias.update', $media) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="chemin">Chemin/URL *</label>
                            <input type="text" 
                                   class="form-control @error('chemin') is-invalid @enderror" 
                                   id="chemin" 
                                   name="chemin" 
                                   value="{{ old('chemin', $media->chemin) }}"
                                   required>
                            @error('chemin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $media->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_contenu">Contenu associé *</label>
                                    <select name="id_contenu" class="form-control @error('id_contenu') is-invalid @enderror" required>
                                        @foreach($contenus as $contenu)
                                            <option value="{{ $contenu->id_contenu }}" {{ old('id_contenu', $media->id_contenu) == $contenu->id_contenu ? 'selected' : '' }}>
                                                {{ $contenu->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_type_media">Type de média *</label>
                                    <select name="id_type_media" class="form-control @error('id_type_media') is-invalid @enderror" required>
                                        @foreach($typeMedias as $typeMedia)
                                            <option value="{{ $typeMedia->id_type_media }}" {{ old('id_type_media', $media->id_type_media) == $typeMedia->id_type_media ? 'selected' : '' }}>
                                                {{ $typeMedia->nom_media }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_type_media')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le média
                        </button>
                        <a href="{{ route('medias.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection