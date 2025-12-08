@extends('layouts.app')

@section('title', 'Gestion des Rôles')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-user-tag"></i>
                        Liste des Rôles
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouveau Rôle
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
                                <th>Nom du Rôle</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                
                                <td>
                                    <span class="badge badge-secondary">{{ $role->nom_role }}</span>
                                </td>
                                <td>{{ $role->created_at->format('d/m/Y H:i') }}</td>
                                <td style="width: 220px;">
                                    <a href="{{ route('roles.show', $role) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('roles.edit', $role) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('roles.destroy', $role) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
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
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Aucun rôle trouvé
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