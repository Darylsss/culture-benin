@extends('layouts.app')

@section('title', 'Modifier le Rôle')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier le Rôle : {{ $role->nom_role }}
                    </h3>
                </div>
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nom_role">Nom du rôle *</label>
                            <input type="text" 
                                   class="form-control @error('nom_role') is-invalid @enderror" 
                                   id="nom_role" 
                                   name="nom_role" 
                                   value="{{ old('nom_role', $role->nom_role) }}"
                                   required>
                            @error('nom_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier le rôle
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection