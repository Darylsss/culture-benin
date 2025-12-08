@extends('layouts.app')

@section('title', 'Détails du Contenu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails du Contenu : {{ $contenu->titre }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('contenus.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Images Gallery - En haut pour plus de visibilité -->
                    @if($contenu->medias->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-images"></i> Galerie d'images
                                <span class="badge badge-secondary">{{ $contenu->medias->count() }}</span>
                            </h5>
                            <div class="row">
                                @foreach($contenu->medias as $media)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card media-card">
                                        <a href="{{ asset($media->chemin) }}" 
                                           data-lightbox="contenu-{{ $contenu->id_contenu }}" 
                                           data-title="{{ $contenu->titre }}">
                                            <img src="{{ asset($media->chemin) }}" 
                                                 class="card-img-top media-thumbnail" 
                                                 alt="Image {{ $loop->iteration }}"
                                                 onerror="this.src='{{ asset('images/defaults/no-image.jpg') }}'">
                                        </a>
                                        <div class="card-footer p-2 bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted text-truncate" style="font-size: 11px;">
                                                    {{ $media->nom_original ?? 'Image ' . $loop->iteration }}
                                                </small>
                                                <div class="media-actions">
                                                    <a href="{{ asset($media->chemin) }}" 
                                                       target="_blank" 
                                                       class="btn btn-xs btn-info"
                                                       title="Voir en grand">
                                                        <i class="fas fa-expand"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-xs btn-danger delete-media-btn"
                                                            data-id="{{ $media->id_media }}"
                                                            data-title="{{ $contenu->titre }}"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>ID:</dt>
                                <dd><span class="badge badge-dark">{{ $contenu->id_contenu }}</span></dd>

                                <dt>Titre:</dt>
                                <dd><h5 class="mb-0">{{ $contenu->titre }}</h5></dd>

                                <dt>Auteur:</dt>
                                <dd>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-small mr-2">
                                            {{ strtoupper(substr($contenu->auteur->prenom ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $contenu->auteur->prenom ?? 'N/A' }} {{ $contenu->auteur->nom ?? '' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $contenu->auteur->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </dd>

                                <dt>Type de contenu:</dt>
                                <dd>
                                    <span class="badge badge-purple">{{ $contenu->typeContenu->nom_contenu ?? 'N/A' }}</span>
                                </dd>

                                <dt>Région:</dt>
                                <dd>
                                    <span class="badge badge-primary">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $contenu->region->nom_region ?? 'N/A' }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Statut:</dt>
                                <dd>
                                    @if($contenu->statut == 'publié')
                                        <span class="badge badge-success">Publié</span>
                                    @elseif($contenu->statut == 'brouillon')
                                        <span class="badge badge-secondary">Brouillon</span>
                                    @elseif($contenu->statut == 'en_attente')
                                        <span class="badge badge-warning">En attente</span>
                                    @else
                                        <span class="badge badge-primary">{{ $contenu->statut }}</span>
                                    @endif
                                </dd>

                                <dt>Langue:</dt>
                                <dd>
                                    <span class="badge badge-info">
                                        <i class="fas fa-language"></i>
                                        {{ $contenu->langue->nom_langue ?? 'N/A' }}
                                    </span>
                                </dd>

                                <dt>Date de création:</dt>
                                <dd>
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') }}
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($contenu->date_creation)->locale('fr')->diffForHumans() }})
                                    </small>
                                </dd>

                                <dt>Date de validation:</dt>
                                <dd>
                                    @if($contenu->date_validation)
                                        <i class="fas fa-check-circle text-success"></i>
                                        {{ \Carbon\Carbon::parse($contenu->date_validation)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-clock"></i> Non validé
                                        </span>
                                    @endif
                                </dd>

                                <dt>Modérateur:</dt>
                                <dd>
                                    @if($contenu->moderateur)
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-user-shield"></i>
                                            {{ $contenu->moderateur->prenom }} {{ $contenu->moderateur->nom }}
                                        </span>
                                    @else
                                        <span class="text-muted">Aucun modérateur assigné</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Contenu texte -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Contenu:</dt>
                            <dd class="border rounded p-3 bg-light content-text">
                                {!! nl2br(e($contenu->texte)) !!}
                            </dd>
                        </div>
                    </div>

                    <!-- Contenu parent -->
                    @if($contenu->parent)
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Contenu parent:</dt>
                            <dd>
                                <div class="alert alert-info p-2">
                                    <i class="fas fa-level-up-alt"></i>
                                    <a href="{{ route('contenus.show', $contenu->parent) }}" class="ml-2">
                                        {{ $contenu->parent->titre }}
                                    </a>
                                </div>
                            </dd>
                        </div>
                    </div>
                    @endif

                    <!-- Contenus enfants (réponses) -->
                    @if($contenu->enfants->count() > 0)
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Contenus liés ({{ $contenu->enfants->count() }}):</dt>
                            <dd>
                                <div class="list-group">
                                    @foreach($contenu->enfants as $enfant)
                                    <a href="{{ route('contenus.show', $enfant) }}" 
                                       class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $enfant->titre }}</h6>
                                            <small>
                                                @if($enfant->statut == 'publié')
                                                    <span class="badge badge-success">Publié</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $enfant->statut }}</span>
                                                @endif
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            Par {{ $enfant->auteur->prenom ?? 'Anonyme' }} 
                                            le {{ \Carbon\Carbon::parse($enfant->date_creation)->format('d/m/Y') }}
                                        </small>
                                    </a>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    </div>
                    @endif

                    <!-- Commentaires -->
                    @if($contenu->commentaires->count() > 0)
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Commentaires ({{ $contenu->commentaires->count() }}):</dt>
                            <dd>
                                <div class="comment-section">
                                    @foreach($contenu->commentaires as $commentaire)
                                    <div class="card mb-2">
                                        <div class="card-body p-2">
                                            <div class="d-flex">
                                                <div class="user-avatar-xs mr-2">
                                                    {{ strtoupper(substr($commentaire->utilisateur->prenom ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $commentaire->utilisateur->prenom ?? 'Utilisateur' }}</strong>
                                                    <small class="text-muted ml-2">
                                                        {{ \Carbon\Carbon::parse($commentaire->created_at)->locale('fr')->diffForHumans() }}
                                                    </small>
                                                    <p class="mb-0">{{ $commentaire->texte }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('contenus.edit', $contenu) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('contenus.destroy', $contenu) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
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

.media-card {
    transition: transform 0.2s;
    border: 1px solid #dee2e6;
}

.media-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.media-thumbnail {
    height: 150px;
    object-fit: cover;
    cursor: pointer;
}

.media-actions .btn-xs {
    padding: 0.15rem 0.3rem;
    font-size: 0.7rem;
    line-height: 1;
}

.user-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary, #007bff), var(--accent, #6f42c1));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 16px;
}

.user-avatar-xs {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 12px;
}

.content-text {
    line-height: 1.8;
    font-size: 16px;
    white-space: pre-wrap;
}

.comment-section {
    max-height: 300px;
    overflow-y: auto;
}
</style>

@push('scripts')
<!-- Lightbox pour les images -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
// Configuration de lightbox
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'albumLabel': "Image %1 sur %2",
    'disableScrolling': true
});

// Suppression d'une image
document.querySelectorAll('.delete-media-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const mediaId = this.dataset.id;
        const titre = this.dataset.title;
        
        if (confirm(`Êtes-vous sûr de vouloir supprimer cette image du contenu "${titre}" ?`)) {
            fetch(`/medias/${mediaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Erreur lors de la suppression');
            })
            .then(data => {
                if (data.success) {
                    // Supprimer la carte de la vue
                    this.closest('.col-md-3').remove();
                    
                    // Mettre à jour le compteur
                    const badge = document.querySelector('.badge.badge-secondary');
                    if (badge) {
                        const count = parseInt(badge.textContent) - 1;
                        badge.textContent = count;
                        
                        // Cacher la galerie si plus d'images
                        if (count === 0) {
                            document.querySelector('.row.mb-4').remove();
                        }
                    }
                    
                    // Message de succès
                    alert('Image supprimée avec succès');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression de l\'image');
            });
        }
    });
});

// Gestion des erreurs d'images
document.querySelectorAll('img.media-thumbnail').forEach(img => {
    img.addEventListener('error', function() {
        this.src = '{{ asset("images/defaults/no-image.jpg") }}';
        this.alt = 'Image non disponible';
    });
});
</script>
@endpush
@endsection