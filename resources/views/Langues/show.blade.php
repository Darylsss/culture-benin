@extends('layouts.app')

@section('title', 'Détails de la Langue')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails de la Langue
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('langues.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8">{{ $langue->id_langue }}</dd>

                        <dt class="col-sm-4">Nom:</dt>
                        <dd class="col-sm-8">{{ $langue->nom_langue }}</dd>

                        <dt class="col-sm-4">Code:</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-primary">{{ $langue->code_langue }}</span>
                        </dd>

                        <dt class="col-sm-4">Description:</dt>
                        <dd class="col-sm-8">
                            {{ $langue->description ?: 'Aucune description' }}
                        </dd>

                        <dt class="col-sm-4">Date création:</dt>
                        <dd class="col-sm-8">{{ $langue->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-sm-4">Dernière modification:</dt>
                        <dd class="col-sm-8">{{ $langue->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('langues.edit', $langue) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('langues.destroy', $langue) }}" method="POST" style="display: inline;">
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