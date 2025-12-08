@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Liste des Utilisateurs
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('utilisateurs.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouvel Utilisateur
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nom & Prénom</th>
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($utilisateurs as $utilisateur)
                            <tr>
                                <td>{{ $utilisateur->id_utilisateur }}</td>
                                <td>
                                    <strong>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</strong>
                                    @if($utilisateur->statut)
                                        <br><small class="text-muted">{{ $utilisateur->statut }}</small>
                                    @endif
                                </td>
                                
                               
                               
                                <td style="width: 220px;">
                                    <a href="{{ route('utilisateurs.show', $utilisateur) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('utilisateurs.edit', $utilisateur) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Aucun utilisateur trouvé
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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