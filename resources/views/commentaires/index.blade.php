@extends('layouts.app')

@section('title', 'Gestion des Commentaires')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-comments"></i>
                        Liste des Commentaires
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('commentaires.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouveau Commentaire
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
                                <th>Utilisateur</th>
                                <th>Contenu</th>
                                <th>Commentaire</th>
                              
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commentaires as $commentaire)
                            <tr>
                                <td>{{ $commentaire->id_commentaire }}</td>
                                <td>
                                    <strong>{{ $commentaire->utilisateur->prenom ?? 'N/A' }} {{ $commentaire->utilisateur->nom ?? '' }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('contenus.show', $commentaire->contenu) }}">
                                        {{ Str::limit($commentaire->contenu->titre, 30) }}
                                    </a>
                                </td>
                                <td>{{ Str::limit($commentaire->texte, 50) }}</td>
                               
                               
                                <td style="width: 220px;">
                                    <a href="{{ route('commentaires.show', $commentaire) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('commentaires.edit', $commentaire) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('commentaires.destroy', $commentaire) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
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
                                <td colspan="7" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Aucun commentaire trouvé
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
@endsection