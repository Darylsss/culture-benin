@extends('layouts.app')

@section('title', 'Modifier la Langue')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier la Langue : {{ $langue->nom_langue }}
                    </h3>
                </div>
                <form action="{{ route('langues.update', $langue) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <!-- Champ Nom -->
                        <div class="form-group">
                            <label for="nom_langue">Nom de la langue *</label>
                            <input type="text" 
                                   class="form-control @error('nom_langue') is-invalid @enderror" 
                                   id="nom_langue" 
                                   name="nom_langue" 
                                   value="{{ old('nom_langue', $langue->nom_langue) }}"
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
                                   value="{{ old('code_langue', $langue->code_langue) }}"
                                   maxlength="10"
                                   required>
                            @error('code_langue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $langue->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier la langue
                        </button>
                        <a href="{{ route('langues.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection