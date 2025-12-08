@extends('layouts.app')

@section('title', 'Détails du Commentaire')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails du Commentaire
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('commentaires.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>ID:</dt>
                                <dd>{{ $commentaire->id_commentaire }}</dd>

                                <dt>Utilisateur:</dt>
                                <dd>
                                    <span class="badge badge-primary">
                                        {{ $commentaire->utilisateur->prenom ?? 'N/A' }} {{ $commentaire->utilisateur->nom ?? '' }}
                                    </span>
                                </dd>

                                <dt>Contenu:</dt>
                                <dd>
                                    <a href="{{ route('contenus.show', $commentaire->contenu) }}" class="badge badge-success">
                                        {{ $commentaire->contenu->titre }}
                                    </a>
                                </dd>

                                <dt>Date:</dt>
                                <dd>{{ \Carbon\Carbon::parse($commentaire->date)->format('d/m/Y') }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Note:</dt>
                                <dd>
                                    @if($commentaire->note)
                                        <div class="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $commentaire->note)
                                                    <i class="fas fa-star text-warning fa-lg"></i>
                                                @else
                                                    <i class="far fa-star text-warning fa-lg"></i>
                                                @endif
                                            @endfor
                                            <span class="ml-2">({{ $commentaire->note }}/5)</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Aucune note</span>
                                    @endif
                                </dd>

                                <dt>Date création:</dt>
                                <dd>{{ $commentaire->created_at->format('d/m/Y H:i') }}</dd>

                                <dt>Dernière modification:</dt>
                                <dd>{{ $commentaire->updated_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Commentaire:</dt>
                            <dd class="border rounded p-3 bg-light">
                                {!! nl2br(e($commentaire->texte)) !!}
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('commentaires.edit', $commentaire) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('commentaires.destroy', $commentaire) }}" method="POST" style="display: inline;">
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