@extends('layouts.app')

@section('title', 'Gestion des Médias')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-photo-video"></i>
                        Liste des Médias
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('medias.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouveau Média
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
                                <th>Chemin/URL</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medias as $media)
                            <tr>
                                <td>{{ $media->id_media }}</td>
                                <td>
                                    <a href="{{ $media->chemin }}" target="_blank" title="Voir le média">
                                        {{ Str::limit($media->chemin, 30) }}
                                    </a>
                                    @if(in_array(pathinfo($media->chemin, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <br>
                                        <img src="{{ $media->chemin }}" alt="Preview" style="max-width: 50px; max-height: 50px;" class="mt-1">
                                    @endif
                                </td>
                                
                               
                                <td style="width: 220px;">
                                    <a href="{{ route('medias.show', $media) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('medias.edit', $media) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('medias.destroy', $media) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
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
                                    Aucun média trouvé
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