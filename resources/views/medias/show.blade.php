@extends('layouts.app')

@section('title', 'Détails du Média')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails du Média
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('medias.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>ID:</dt>
                                <dd>{{ $media->id_media }}</dd>

                                <dt>Chemin/URL:</dt>
                                <dd>
                                    <a href="{{ $media->chemin }}" target="_blank" class="text-break">
                                        {{ $media->chemin }}
                                    </a>
                                </dd>

                                <dt>Contenu associé:</dt>
                                <dd>
                                    @if($media->contenu)
                                        <a href="{{ route('contenus.show', $media->contenu) }}" class="badge badge-primary">
                                            {{ $media->contenu->titre }}
                                        </a>
                                    @else
                                        <span class="text-muted">Aucun contenu associé</span>
                                    @endif
                                </dd>

                                <dt>Type de média:</dt>
                                <dd>
                                    <span class="badge badge-pink">{{ $media->typeMedia->nom_media ?? 'N/A' }}</span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Description:</dt>
                                <dd>{{ $media->description ?: 'Aucune description' }}</dd>

                                <dt>Date création:</dt>
                                <dd>{{ $media->created_at->format('d/m/Y H:i') }}</dd>

                                <dt>Dernière modification:</dt>
                                <dd>{{ $media->updated_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Aperçu du média -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Aperçu:</dt>
                            <dd class="border rounded p-3 bg-light text-center">
                                @php
                                    $extension = strtolower(pathinfo($media->chemin, PATHINFO_EXTENSION));
                                @endphp
                                
                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ $media->chemin }}" alt="Aperçu du média" 
                                         style="max-width: 100%; max-height: 400px;" 
                                         class="img-fluid rounded">
                                    <p class="mt-2 text-muted">Image - {{ strtoupper($extension) }}</p>
                                @elseif(in_array($extension, ['mp4', 'avi', 'mov', 'wmv']))
                                    <video controls style="max-width: 100%; max-height: 400px;" class="rounded">
                                        <source src="{{ $media->chemin }}" type="video/{{ $extension }}">
                                        Votre navigateur ne supporte pas la lecture vidéo.
                                    </video>
                                    <p class="mt-2 text-muted">Vidéo - {{ strtoupper($extension) }}</p>
                                @elseif(in_array($extension, ['mp3', 'wav', 'ogg']))
                                    <audio controls class="w-100">
                                        <source src="{{ $media->chemin }}" type="audio/{{ $extension }}">
                                        Votre navigateur ne supporte pas la lecture audio.
                                    </audio>
                                    <p class="mt-2 text-muted">Audio - {{ strtoupper($extension) }}</p>
                                @else
                                    <div class="p-4 bg-secondary rounded">
                                        <i class="fas fa-file fa-3x text-white mb-2"></i>
                                        <p class="text-white">Fichier - {{ strtoupper($extension) ?: 'INCONNU' }}</p>
                                        <a href="{{ $media->chemin }}" target="_blank" class="btn btn-light">
                                            <i class="fas fa-download"></i> Télécharger
                                        </a>
                                    </div>
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('medias.edit', $media) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('medias.destroy', $media) }}" method="POST" style="display: inline;">
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