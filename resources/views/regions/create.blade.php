@extends('layouts.app')

@section('title', 'Créer une Région')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer une Nouvelle Région
                    </h3>
                </div>
                <form action="{{ route('regions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <!-- Champ Nom -->
                        <div class="form-group">
                            <label for="nom_region">Nom de la région *</label>
                            <input type="text" 
                                   class="form-control @error('nom_region') is-invalid @enderror" 
                                   id="nom_region" 
                                   name="nom_region" 
                                   value="{{ old('nom_region') }}"
                                   placeholder="Ex: Île-de-France, Normandie..."
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
                                      rows="3"
                                      placeholder="Description de la région, sa culture, ses particularités...">{{ old('description') }}</textarea>
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
                                           value="{{ old('population') }}"
                                           placeholder="Ex: 12000000"
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
                                           value="{{ old('superficie') }}"
                                           placeholder="Ex: 12051.50"
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
                                   value="{{ old('localisation') }}"
                                   placeholder="Ex: Nord de la France, Sud-ouest...">
                            @error('localisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer la région
                        </button>
                        <a href="{{ route('regions.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection