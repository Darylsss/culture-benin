@extends('layouts.app')

@section('title', 'Modifier la Région')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Modifier la Région : {{ $region->nom_region }}
                    </h3>
                </div>
                <form action="{{ route('regions.update', $region) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        
                        <!-- Champ Nom -->
                        <div class="form-group">
                            <label for="nom_region">Nom de la région *</label>
                            <input type="text" 
                                   class="form-control @error('nom_region') is-invalid @enderror" 
                                   id="nom_region" 
                                   name="nom_region" 
                                   value="{{ old('nom_region', $region->nom_region) }}"
                                   required>
                            @error('nom_region')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champ Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $region->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Champ Population -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="population">Population</label>
                                    <input type="number" 
                                           class="form-control @error('population') is-invalid @enderror" 
                                           id="population" 
                                           name="population" 
                                           value="{{ old('population', $region->population) }}"
                                           min="0">
                                    @error('population')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Champ Superficie -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="superficie">Superficie (km²)</label>
                                    <input type="number" 
                                           class="form-control @error('superficie') is-invalid @enderror" 
                                           id="superficie" 
                                           name="superficie" 
                                           value="{{ old('superficie', $region->superficie) }}"
                                           step="0.01"
                                           min="0">
                                    @error('superficie')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Champ Localisation -->
                        <div class="form-group">
                            <label for="localisation">Localisation</label>
                            <input type="text" 
                                   class="form-control @error('localisation') is-invalid @enderror" 
                                   id="localisation" 
                                   name="localisation" 
                                   value="{{ old('localisation', $region->localisation) }}">
                            @error('localisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Modifier la région
                        </button>
                        <a href="{{ route('regions.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection