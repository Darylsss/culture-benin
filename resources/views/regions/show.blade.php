@extends('layouts.app')

@section('title', 'Détails de la Région')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Détails de la Région : {{ $region->nom_region }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('regions.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl>
                                <dt>ID:</dt>
                                <dd>{{ $region->id_region }}</dd>

                                <dt>Nom:</dt>
                                <dd>
                                    <span class="badge badge-info">{{ $region->nom_region }}</span>
                                </dd>

                                <dt>Localisation:</dt>
                                <dd>{{ $region->localisation ?: 'Non spécifiée' }}</dd>

                                <dt>Population:</dt>
                                <dd>
                                    @if($region->population)
                                        <span class="text-success">
                                            <i class="fas fa-users"></i>
                                            {{ number_format($region->population, 0, ',', ' ') }} habitants
                                        </span>
                                    @else
                                        <span class="text-muted">Non spécifiée</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Superficie:</dt>
                                <dd>
                                    @if($region->superficie)
                                        <span class="text-primary">
                                            <i class="fas fa-map"></i>
                                            {{ number_format($region->superficie, 2, ',', ' ') }} km²
                                        </span>
                                    @else
                                        <span class="text-muted">Non spécifiée</span>
                                    @endif
                                </dd>

                                <dt>Date création:</dt>
                                <dd>{{ $region->created_at->format('d/m/Y H:i') }}</dd>

                                <dt>Dernière modification:</dt>
                                <dd>{{ $region->updated_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($region->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <dt>Description:</dt>
                            <dd class="border rounded p-3 bg-light">
                                {{ $region->description }}
                            </dd>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('regions.edit', $region) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('regions.destroy', $region) }}" method="POST" style="display: inline;">
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