@extends('layouts.app')

@section('title', 'Modifier le Type de Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Type de Contenu : {{ $typeContenu->nom_contenu }}
                    </h3>
                </div>
                <form action="{{ route('type-contenus.update', $typeContenu) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_contenu">Nom du type de contenu *</label>
                            <input type="text" 
                                   class="form-control @error('nom_contenu') is-invalid @enderror" 
                                   id="nom_contenu" 
                                   name="nom_contenu" 
                                   value="{{ old('nom_contenu', $typeContenu->nom_contenu) }}"
                                   required>
                            @error('nom_contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le type
                        </button>
                        <a href="{{ route('type-contenus.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection