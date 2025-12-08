@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="container-fluid">
    <!-- Header du Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
           
                    <h1 class="welcome-title">
                       
                        Bonjour, {{ Auth::user()->prenom ?? Auth::user()->name }} !
                    </h1>
                    <p class="welcome-subtitle">Voici un aperçu de votre plateforme Culture Bénin</p>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Statistiques Principales -->
    <div class="row mb-4">
        <!-- Contenus -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ \App\Models\Contenu::count() }}</div>
                    <div class="stat-label">Contenus</div>
                </div>
                <a href="{{ route('contenus.index') }}" class="stat-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ \App\Models\Utilisateur::count() }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
                <a href="{{ route('utilisateurs.index') }}" class="stat-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Langues -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-language"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ \App\Models\Langue::count() }}</div>
                    <div class="stat-label">Langues</div>
                </div>
                <a href="{{ route('langues.index') }}" class="stat-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Régions -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ \App\Models\Region::count() }}</div>
                    <div class="stat-label">Régions</div>
                </div>
                <a href="{{ route('regions.index') }}" class="stat-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques Secondaires -->
    <div class="row mb-4">
        <!-- Contenus Publiés -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="mini-stat stat-green">
                <div class="mini-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="mini-stat-content">
                    <div class="mini-stat-number">{{ \App\Models\Contenu::where('statut', 'publié')->count() }}</div>
                    <div class="mini-stat-label">Publiés</div>
                </div>
            </div>
        </div>

        <!-- En Attente -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="mini-stat stat-orange">
                <div class="mini-stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="mini-stat-content">
                    <div class="mini-stat-number">{{ \App\Models\Contenu::where('statut', 'en_attente')->count() }}</div>
                    <div class="mini-stat-label">En attente</div>
                </div>
            </div>
        </div>

        <!-- Médias -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="mini-stat stat-purple">
                <div class="mini-stat-icon">
                    <i class="fas fa-images"></i>
                </div>
                <div class="mini-stat-content">
                    <div class="mini-stat-number">{{ \App\Models\Media::count() }}</div>
                    <div class="mini-stat-label">Médias</div>
                </div>
            </div>
        </div>

        <!-- Commentaires -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="mini-stat stat-teal">
                <div class="mini-stat-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="mini-stat-content">
                    <div class="mini-stat-number">{{ \App\Models\Commentaire::count() }}</div>
                    <div class="mini-stat-label">Commentaires</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableaux d'Activité -->
    <div class="row">
        <!-- Derniers Contenus -->
        <div class="col-lg-6 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h3 class="activity-title">
                        <i class="fas fa-newspaper"></i>
                        Derniers Contenus
                    </h3>
                </div>
                <div class="activity-body">
                    @php
                        $derniersContenus = \App\Models\Contenu::with(['auteur', 'typeContenu'])
                            ->orderBy('created_at', 'DESC')
                            ->limit(6)
                            ->get();
                    @endphp
                    @forelse($derniersContenus as $contenu)
                        <div class="activity-item">
                            <div class="activity-icon {{ $contenu->statut === 'publié' ? 'icon-success' : ($contenu->statut === 'en_attente' ? 'icon-warning' : 'icon-gray') }}">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-name">{{ Str::limit($contenu->titre, 40) }}</div>
                                <div class="activity-meta">
                                    Par {{ $contenu->auteur->prenom ?? 'N/A' }} • 
                                    <span class="badge badge-{{ $contenu->statut === 'publié' ? 'success' : ($contenu->statut === 'en_attente' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($contenu->statut) }}
                                    </span>
                                </div>
                            </div>
                            <div class="activity-date">
                                {{ $contenu->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                            <p>Aucun contenu pour le moment</p>
                        </div>
                    @endforelse
                </div>
                <div class="activity-footer">
                    <a href="{{ route('contenus.index') }}" class="btn-view-all">
                        Voir tous les contenus <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Répartition par Statut -->
        <div class="col-lg-6 mb-4">
            <div class="activity-card">
                <div class="activity-header">
                    <h3 class="activity-title">
                        <i class="fas fa-chart-pie"></i>
                        Répartition des Contenus
                    </h3>
                </div>
                <div class="activity-body">
                    @php
                        $statutStats = [
                            ['statut' => 'publié', 'label' => 'Publiés', 'color' => 'success', 'icon' => 'check-circle'],
                            ['statut' => 'en_attente', 'label' => 'En attente', 'color' => 'warning', 'icon' => 'clock'],
                            ['statut' => 'brouillon', 'label' => 'Brouillons', 'color' => 'secondary', 'icon' => 'edit'],
                            ['statut' => 'rejeté', 'label' => 'Rejetés', 'color' => 'danger', 'icon' => 'times-circle'],
                        ];
                        $total = \App\Models\Contenu::count();
                    @endphp

                    @foreach($statutStats as $stat)
                        @php
                            $count = \App\Models\Contenu::where('statut', $stat['statut'])->count();
                            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                        @endphp
                        <div class="stat-row">
                            <div class="stat-row-icon icon-{{ $stat['color'] }}">
                                <i class="fas fa-{{ $stat['icon'] }}"></i>
                            </div>
                            <div class="stat-row-label">{{ $stat['label'] }}</div>
                            <div class="stat-row-value">{{ $count }}</div>
                            <div class="stat-row-bar">
                                <div class="stat-row-progress bg-{{ $stat['color'] }}" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="stat-row-percent">{{ $percentage }}%</div>
                        </div>
                    @endforeach

                    <hr class="my-4">

                    <h5 class="mb-3" style="font-size: 16px; font-weight: 600; color: #0F172A;">
                        <i class="fas fa-map-marked-alt mr-2" style="color: #F59E0B;"></i>
                        Top Régions
                    </h5>

                    @php
                        $topRegions = \App\Models\Contenu::select('id_region', \DB::raw('count(*) as total'))
                            ->groupBy('id_region')
                            ->orderBy('total', 'DESC')
                            ->limit(5)
                            ->get();
                    @endphp

                    @forelse($topRegions as $regionStat)
                        <div class="region-item">
                            <div class="region-name">
                                <i class="fas fa-map-pin mr-2" style="color: #3B82F6;"></i>
                                {{ $regionStat->region->nom_region ?? 'Inconnu' }}
                            </div>
                            <div class="region-count">
                                <span class="badge badge-primary">{{ $regionStat->total }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucune donnée disponible</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="row">
        <div class="col-12">
            <div class="quick-actions">
                <h3 class="quick-actions-title">
                    <i class="fas fa-bolt"></i>
                    Actions Rapides
                </h3>
                <div class="quick-actions-grid">
                    <a href="{{ route('contenus.create') }}" class="quick-action-btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Nouveau Contenu</span>
                    </a>
                    <a href="{{ route('utilisateurs.create') }}" class="quick-action-btn btn-success">
                        <i class="fas fa-user-plus"></i>
                        <span>Ajouter Utilisateur</span>
                    </a>
                    <a href="{{ route('langues.create') }}" class="quick-action-btn btn-warning">
                        <i class="fas fa-language"></i>
                        <span>Nouvelle Langue</span>
                    </a>
                    <a href="{{ route('regions.create') }}" class="quick-action-btn btn-info">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Nouvelle Région</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #1E40AF;
    --primary-light: #3B82F6;
    --accent: #F59E0B;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
    --info: #3B82F6;
    --dark: #0F172A;
    --gray: #64748B;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    border-radius: 16px;
    padding: 32px 40px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 40px rgba(30, 64, 175, 0.3);
    animation: slideInDown 0.6s ease-out;
}

.welcome-title {
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
}

.welcome-title i {
    color: var(--accent);
    margin-right: 12px;
}

.welcome-subtitle {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
}

.welcome-date {
    font-size: 18px;
    font-weight: 600;
    opacity: 0.9;
}

.welcome-date i {
    margin-right: 8px;
    color: var(--accent);
}

/* Stat Cards Principales */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 2px solid transparent;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--card-color-1), var(--card-color-2));
}

.stat-primary { --card-color-1: #1E40AF; --card-color-2: #3B82F6; }
.stat-success { --card-color-1: #10B981; --card-color-2: #34D399; }
.stat-warning { --card-color-1: #F59E0B; --card-color-2: #FCD34D; }
.stat-info { --card-color-1: #3B82F6; --card-color-2: #60A5FA; }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--card-color-1), var(--card-color-2));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
    margin-bottom: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.stat-number {
    font-size: 36px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 4px;
}

.stat-label {
    font-size: 16px;
    color: var(--gray);
    font-weight: 600;
}

.stat-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 16px;
    color: var(--card-color-1);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.stat-link:hover {
    gap: 12px;
    color: var(--card-color-2);
}

/* Mini Stats */
.mini-stat {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    border-left: 4px solid var(--stat-color);
}

.mini-stat:hover {
    transform: translateX(4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.stat-green { --stat-color: #10B981; }
.stat-orange { --stat-color: #F59E0B; }
.stat-purple { --stat-color: #8B5CF6; }
.stat-teal { --stat-color: #14B8A6; }

.mini-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: var(--stat-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    opacity: 0.9;
}

.mini-stat-number {
    font-size: 28px;
    font-weight: 700;
    color: var(--dark);
}

.mini-stat-label {
    font-size: 14px;
    color: var(--gray);
    font-weight: 500;
}

/* Activity Cards */
.activity-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.activity-header {
    padding: 24px 28px;
    border-bottom: 1px solid #E2E8F0;
}

.activity-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.activity-title i {
    color: var(--accent);
    margin-right: 10px;
}

.activity-body {
    padding: 20px 28px;
    max-height: 500px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #F1F5F9;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

.icon-success { background: linear-gradient(135deg, #10B981, #34D399); }
.icon-warning { background: linear-gradient(135deg, #F59E0B, #FCD34D); }
.icon-gray { background: linear-gradient(135deg, #64748B, #94A3B8); }

.activity-details {
    flex: 1;
}

.activity-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 4px;
}

.activity-meta {
    font-size: 13px;
    color: var(--gray);
}

.activity-date {
    font-size: 13px;
    color: var(--gray);
    font-weight: 500;
}

.activity-footer {
    padding: 16px 28px;
    border-top: 1px solid #E2E8F0;
    text-align: center;
}

.btn-view-all {
    color: var(--primary);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    color: var(--primary-light);
}

/* Stat Rows */
.stat-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #F1F5F9;
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-row-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: white;
}

.stat-row-label {
    flex: 1;
    font-size: 14px;
    font-weight: 600;
    color: var(--dark);
}

.stat-row-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--dark);
    min-width: 40px;
}

.stat-row-bar {
    width: 100px;
    height: 8px;
    background: #F1F5F9;
    border-radius: 4px;
    overflow: hidden;
}

.stat-row-progress {
    height: 100%;
    border-radius: 4px;
    transition: width 0.6s ease;
}

.stat-row-percent {
    font-size: 13px;
    font-weight: 600;
    color: var(--gray);
    min-width: 45px;
    text-align: right;
}

/* Region Items */
.region-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #F1F5F9;
}

.region-item:last-child {
    border-bottom: none;
}

.region-name {
    font-size: 14px;
    font-weight: 500;
    color: var(--dark);
}

/* Quick Actions */
.quick-actions {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    margin-top: 16px;
}

.quick-actions-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 24px 0;
}

.quick-actions-title i {
    color: var(--accent);
    margin-right: 10px;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 24px;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: none;
}

.quick-action-btn i {
    font-size: 32px;
}

.quick-action-btn.btn-primary {
    background: linear-gradient(135deg, #1E40AF, #3B82F6);
    box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
}

.quick-action-btn.btn-success {
    background: linear-gradient(135deg, #10B981, #34D399);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.quick-action-btn.btn-warning {
    background: linear-gradient(135deg, #F59E0B, #FCD34D);
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.quick-action-btn.btn-info {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.quick-action-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Badges */
.badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-success { background: #10B981; color: white; }
.badge-warning { background: #F59E0B; color: white; }
.badge-secondary { background: #64748B; color: white; }
.badge-danger { background: #EF4444; color: white; }
.badge-primary { background: #3B82F6; color: white; }

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-banner {
        flex-direction: column;
        gap: 16px;
        text-align: center;
        padding: 24px;
    }

    .welcome-title {
        font-size: 24px;
    }

    .stat-number {
        font-size: 28px;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection