@extends('layouts.app')

@section('title', 'Détails de l\'Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails de l'Utilisateur : {{ $utilisateur->prenom }} {{ $utilisateur->nom }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('utilisateurs.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>ID:</dt>
                                <dd>{{ $utilisateur->id_utilisateur }}</dd>

                                <dt>Nom complet:</dt>
                                <dd>
                                    <strong>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</strong>
                                </dd>

                                <dt>Email:</dt>
                                <dd>{{ $utilisateur->email }}</dd>

                                <dt>Sexe:</dt>
                                <dd>
                                    @if($utilisateur->sexe == 'homme')
                                        <span class="badge badge-primary">Homme</span>
                                    @else
                                        <span class="badge badge-pink">Femme</span>
                                    @endif
                                </dd>

                                <dt>Rôle:</dt>
                                <dd>
                                    <span class="badge badge-secondary">{{ $utilisateur->role->nom_role }}</span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Langue:</dt>
                                <dd>
                                    <span class="badge badge-info">{{ $utilisateur->langue->nom_langue }}</span>
                                </dd>

                                <dt>Date d'inscription:</dt>
                                <dd>{{ \Carbon\Carbon::parse($utilisateur->date_inscription)->format('d/m/Y') }}</dd>

                                <dt>Date de naissance:</dt>
                                <dd>
                                    @if($utilisateur->date_naissance)
                                        {{ \Carbon\Carbon::parse($utilisateur->date_naissance)->format('d/m/Y') }}
                                        ({{ \Carbon\Carbon::parse($utilisateur->date_naissance)->age }} ans)
                                    @else
                                        <span class="text-muted">Non spécifiée</span>
                                    @endif
                                </dd>

                                <dt>Statut:</dt>
                                <dd>{{ $utilisateur->statut ?: 'Non spécifié' }}</dd>

                                <dt>Date création:</dt>
                                <dd>{{ $utilisateur->created_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($utilisateur->photo)
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Photo:</dt>
                            <dd>
                                <img src="{{ $utilisateur->photo }}" alt="Photo de {{ $utilisateur->prenom }}" 
                                     class="img-thumbnail" style="max-width: 200px;">
                            </dd>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST" style="display: inline;">
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

<style>
.badge-pink {
    background-color: #e83e8c;
    color: white;
}
</style>
@endsection