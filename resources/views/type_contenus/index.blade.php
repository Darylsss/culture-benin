@extends('layouts.app')

@section('title', 'Gestion des Types de Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i>
                        Liste des Types de Contenu
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('type-contenus.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouveau Type
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
                                <th>Nom du Type</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($typeContenus as $typeContenu)
                            <tr>
                                <td>{{ $typeContenu->id_type_contenu }}</td>
                                <td>
                                    <span class="badge ">{{ $typeContenu->nom_contenu }}</span>
                                </td>
                              
                                <td style="width: 220px;">
                                    <a href="{{ route('type-contenus.show', $typeContenu) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('type-contenus.edit', $typeContenu) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('type-contenus.destroy', $typeContenu) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de contenu ?')">
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
                                    Aucun type de contenu trouvé
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
.badge-purple {
    background-color: #6f42c1;
    color: white;
}
</style>
@endsection