@extends('layouts.app')

@section('title', 'Créer un Rôle')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouveau Rôle
                    </h3>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_role">Nom du rôle *</label>
                            <input type="text" 
                                   class="form-control @error('nom_role') is-invalid @enderror" 
                                   id="nom_role" 
                                   name="nom_role" 
                                   value="{{ old('nom_role') }}"
                                   placeholder="Ex: Administrateur, Modérateur, Utilisateur..."
                                   required>
                            @error('nom_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Le nom du rôle doit être unique
                            </small>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer le rôle
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection