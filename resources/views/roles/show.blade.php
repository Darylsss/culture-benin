@extends('layouts.app')

@section('title', 'Détails du Rôle')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails du Rôle
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8">{{ $role->id_role }}</dd>

                        <dt class="col-sm-4">Nom:</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-secondary">{{ $role->nom_role }}</span>
                        </dd>

                        <dt class="col-sm-4">Date création:</dt>
                        <dd class="col-sm-8">{{ $role->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Dernière modification:</dt>
                        <dd class="col-sm-8">{{ $role->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection