@extends('layouts.app')

@section('title', 'Créer une Langue')

@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer une Nouvelle Langue
                    </h3>
                </div>
                <form action="{{ route('langues.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <!-- Champ Nom -->
                        <div class="form-group">
                            <label for="nom_langue">Nom de la langue *</label>
                            <input type="text" 
                                   class="form-control @error('nom_langue') is-invalid @enderror" 
                                   id="nom_langue" 
                                   name="nom_langue" 
                                   value="{{ old('nom_langue') }}"
                                   placeholder="Ex: Français, English..."
                                   required>
                            @error('nom_langue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Code -->
                        <div class="form-group">
                            <label for="code_langue">Code de la langue *</label>
                            <input type="text" 
                                   class="form-control @error('code_langue') is-invalid @enderror" 
                                   id="code_langue" 
                                   name="code_langue" 
                                   value="{{ old('code_langue') }}"
                                   placeholder="Ex: fr, en, es..."
                                   maxlength="10"
                                   required>
                            @error('code_langue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Code unique (maximum 10 caractères)
                            </small>
                        </div>

                        <!-- Champ Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Description optionnelle de la langue...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer la langue
                        </button>
                        <a href="{{ route('langues.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection