@extends('layouts.app')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Créer un Nouvel Utilisateur
                    </h3>
                </div>
                <form action="{{ route('utilisateurs.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom">Nom *</label>
                                    <input type="text" 
                                           class="form-control @error('nom') is-invalid @enderror" 
                                           id="nom" 
                                           name="nom" 
                                           value="{{ old('nom') }}"
                                           placeholder="Ex: Dupont"
                                           required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prenom">Prénom *</label>
                                    <input type="text" 
                                           class="form-control @error('prenom') is-invalid @enderror" 
                                           id="prenom" 
                                           name="prenom" 
                                           value="{{ old('prenom') }}"
                                           placeholder="Ex: Jean"
                                           required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Ex: jean.dupont@example.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mot_de_passe">Mot de passe *</label>
                            <input type="password" 
                                   class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                   id="mot_de_passe" 
                                   name="mot_de_passe" 
                                   placeholder="Minimum 6 caractères"
                                   required>
                            @error('mot_de_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sexe">Sexe *</label>
                                    <select name="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                                        <option value="">Sélectionner</option>
                                        <option value="homme" {{ old('sexe') == 'homme' ? 'selected' : '' }}>Homme</option>
                                        <option value="femme" {{ old('sexe') == 'femme' ? 'selected' : '' }}>Femme</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_inscription">Date d'inscription *</label>
                                    <input type="date" 
                                           class="form-control @error('date_inscription') is-invalid @enderror" 
                                           id="date_inscription" 
                                           name="date_inscription" 
                                           value="{{ old('date_inscription', date('Y-m-d')) }}"
                                           required>
                                    @error('date_inscription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_naissance">Date de naissance</label>
                                    <input type="date" 
                                           class="form-control @error('date_naissance') is-invalid @enderror" 
                                           id="date_naissance" 
                                           name="date_naissance" 
                                           value="{{ old('date_naissance') }}">
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_role">Rôle *</label>
                                    <select name="id_role" class="form-control @error('id_role') is-invalid @enderror" required>
                                        <option value="">Sélectionner un rôle</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id_role }}" {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
                                                {{ $role->nom_role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_langue">Langue *</label>
                                    <select name="id_langue" class="form-control @error('id_langue') is-invalid @enderror" required>
                                        <option value="">Sélectionner une langue</option>
                                        @foreach($langues as $langue)
                                            <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                                                {{ $langue->nom_langue }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <input type="text" 
                                   class="form-control @error('statut') is-invalid @enderror" 
                                   id="statut" 
                                   name="statut" 
                                   value="{{ old('statut') }}"
                                   placeholder="Ex: Actif, Inactif, En attente...">
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo (URL)</label>
                            <input type="text" 
                                   class="form-control @error('photo') is-invalid @enderror" 
                                   id="photo" 
                                   name="photo" 
                                   value="{{ old('photo') }}"
                                   placeholder="Ex: https://example.com/photo.jpg">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save"></i> Créer l'utilisateur
                        </button>
                        <a href="{{ route('utilisateurs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection