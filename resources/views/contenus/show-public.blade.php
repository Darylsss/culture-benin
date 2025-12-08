
@extends('layouts.public')

@section('title', $contenu->titre)

@section('content')
<div class="content-detail-page">
    <!-- Hero Section avec Glassmorphism -->
    <div class="detail-hero">
        @if($contenu->medias && $contenu->medias->count() > 0)
        <div class="hero-image-container">
            <img src="{{ asset($contenu->medias->first()->chemin) }}" 
                 alt="{{ $contenu->titre }}"
                 class="hero-image"
                 loading="lazy">
            <div class="image-gradient-overlay"></div>
        </div>
        @endif
        
        <div class="hero-content-wrapper">
            <div class="container-lg">
                <!-- Badges flottants -->
                <div class="detail-badges">
                    <span class="badge-category">
                        <i class="fas fa-tag"></i>
                        {{ $contenu->typeContenu->nom_contenu ?? 'Général' }}
                    </span>
                    <span class="badge-region">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $contenu->region->nom_region ?? 'Non spécifiée' }}
                    </span>
                    <span class="badge-language">
                        <i class="fas fa-globe"></i>
                        {{ strtoupper(substr($contenu->langue->nom_langue ?? 'FR', 0, 2)) }}
                    </span>
                </div>
                
                <!-- Titre principal -->
                <h1 class="detail-title">{{ $contenu->titre }}</h1>
                
                <!-- Auteur et date -->
                <div class="author-card">
                    <div class="author-avatar-circle">
                        {{ strtoupper(substr($contenu->auteur->prenom ?? 'A', 0, 1)) }}
                    </div>
                    <div class="author-info">
                        <div class="author-name">{{ $contenu->auteur->prenom ?? 'Anonyme' }} {{ $contenu->auteur->nom ?? '' }}</div>
                        <div class="post-meta">
                            <span class="post-date">
                                <i class="far fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d M Y') }}
                            </span>
                            <span class="post-read-time">
                                <i class="far fa-clock"></i>
                                {{ ceil(str_word_count(strip_tags($contenu->texte)) / 200) }} min de lecture
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu Principal -->
    <div class="detail-main-section">
        <div class="container-lg">
            <div class="content-grid">
                <!-- Article Principal -->
                <main class="main-article">
                    <!-- Introduction -->
                    <div class="article-introduction">
                        <div class="intro-text">
                            <p>{{ Str::limit(strip_tags($contenu->texte), 250) }}</p>
                        </div>
                        <div class="article-stats">
                            <div class="stat-item">
                                <i class="far fa-eye"></i>
                                <span>{{ rand(50, 500) }} vues</span>
                            </div>
                            <div class="stat-item">
                                <i class="far fa-comment"></i>
                                <span>{{ rand(5, 50) }} commentaires</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section Paywall élégante -->
                    <div class="paywall-section">
                        <div class="paywall-card">
                            <div class="paywall-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="paywall-content">
                                <h3>Contenu Premium</h3>
                                <p>Accédez à la suite complète de cet article pour découvrir toute l'histoire, les détails et les analyses approfondies.</p>
                                
                                <div class="paywall-features">
                                    <div class="feature">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Contenu complet détaillé</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Images haute qualité</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Accès permanent</span>
                                    </div>
                                </div>
                                
                                <div class="paywall-actions">
                                    @if(auth()->check())
    @if(auth()->user()->hasAccessToContent($contenu))
        <!-- Si l'utilisateur a déjà accès -->
        <button class="btn-premium" onclick="showFullContent()">
            <i class="fas fa-unlock-alt"></i>
            Lire le contenu complet
        </button>
    @else
        <!-- Si l'utilisateur n'a pas accès -->
        <a href="{{ route('payment.form', ['contenu' => $contenu->id_contenu, 'type' => 'article']) }}" class="btn-premium">
            <i class="fas fa-lock"></i>
            Débloquer pour 500 FCFA
            <small>Paiement sécurisé via FedaPay</small>
        </a>
    @endif
@else
    <!-- Non connecté -->
    <a href="{{ route('login') }}" class="btn-premium">
        <i class="fas fa-sign-in-alt"></i>
        Se connecter pour lire la suite
    </a>
@endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Galerie d'images -->
                    @if($contenu->medias->count() > 1)
                    <div class="gallery-section">
                        <h3 class="section-title">
                            <i class="fas fa-images"></i>
                            Galerie Photos
                        </h3>
                        <div class="gallery-grid">
                            @foreach($contenu->medias->slice(1) as $media)
                            <div class="gallery-item">
                                <div class="gallery-item-inner">
                                    <img src="{{ asset($media->chemin) }}" 
                                         alt="Image {{ $loop->iteration }}"
                                         class="gallery-image"
                                         loading="lazy">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </main>

                <!-- Sidebar -->
                <aside class="article-sidebar">
                    <!-- Informations Article -->
                    <div class="sidebar-card">
                        <h4 class="sidebar-title">
                            <i class="fas fa-info-circle"></i>
                            Informations
                        </h4>
                        <div class="info-list">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="far fa-calendar-check"></i>
                                    Publié le
                                </div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') }}
                                </div>
                            </div>
                            @if($contenu->date_validation)
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-check-circle"></i>
                                    Validé le
                                </div>
                                <div class="info-value">
                                    {{ \Carbon\Carbon::parse($contenu->date_validation)->format('d/m/Y') }}
                                </div>
                            </div>
                            @endif
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-tags"></i>
                                    Type
                                </div>
                                <div class="info-value">
                                    {{ $contenu->typeContenu->nom_contenu ?? 'Non spécifié' }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-map-marked-alt"></i>
                                    Région
                                </div>
                                <div class="info-value">
                                    {{ $contenu->region->nom_region ?? 'Non spécifiée' }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-language"></i>
                                    Langue
                                </div>
                                <div class="info-value">
                                    {{ $contenu->langue->nom_langue ?? 'Non spécifiée' }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="fas fa-user-edit"></i>
                                    Auteur
                                </div>
                                <div class="info-value">
                                    {{ $contenu->auteur->prenom ?? 'Anonyme' }} {{ $contenu->auteur->nom ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Articles Similaires -->
                    @if($similarContents->count() > 0)
                    <div class="sidebar-card">
                        <h4 class="sidebar-title">
                            <i class="fas fa-newspaper"></i>
                            Articles Similaires
                        </h4>
                        <div class="similar-articles">
                            @foreach($similarContents as $similar)
                            <a href="{{ route('contenus.show', $similar->id_contenu) }}" class="similar-article">
                                @if($similar->medias && $similar->medias->count() > 0)
                                <div class="similar-image">
                                    <img src="{{ asset($similar->medias->first()->chemin) }}" 
                                         alt="{{ $similar->titre }}"
                                         loading="lazy">
                                </div>
                                @endif
                                <div class="similar-content">
                                    <h5>{{ Str::limit($similar->titre, 45) }}</h5>
                                    <div class="similar-meta">
                                        <span class="similar-type">{{ $similar->typeContenu->nom_contenu ?? 'Général' }}</span>
                                        <span class="similar-date">{{ \Carbon\Carbon::parse($similar->date_creation)->format('d M') }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Partager -->
                    <div class="sidebar-card">
                        <h4 class="sidebar-title">
                            <i class="fas fa-share-alt"></i>
                            Partager
                        </h4>
                        <div class="share-buttons">
                            <button class="share-btn share-facebook" onclick="shareOnFacebook()">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </button>
                            <button class="share-btn share-twitter" onclick="shareOnTwitter()">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </button>
                            <button class="share-btn share-whatsapp" onclick="shareOnWhatsApp()">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </button>
                            <button class="share-btn share-copy" onclick="copyLink()">
                                <i class="fas fa-link"></i>
                                <span>Copier le lien</span>
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<style>
/* ========== VARIABLES MODERNES ========== */
:root {
    --primary: #4F46E5;
    --primary-light: #6366F1;
    --primary-dark: #4338CA;
    --accent: #F59E0B;
    --accent-light: #FCD34D;
    --dark: #1F2937;
    --dark-light: #374151;
    --light: #FFFFFF;
    --light-gray: #F9FAFB;
    --medium-gray: #E5E7EB;
    --text-gray: #6B7280;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --radius-sm: 0.5rem;
    --radius-md: 0.75rem;
    --radius-lg: 1rem;
    --radius-xl: 1.5rem;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ========== PAGE STRUCTURE ========== */
.content-detail-page {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
}

.container-lg {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ========== HERO SECTION ========== */
.detail-hero {
    position: relative;
    height: 85vh;
    min-height: 600px;
    max-height: 800px;
    margin-bottom: 4rem;
    overflow: hidden;
    border-radius: 0 0 var(--radius-xl) var(--radius-xl);
}

.hero-image-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.6);
    transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.detail-hero:hover .hero-image {
    transform: scale(1.05);
}

.image-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0.2) 0%,
        rgba(0, 0, 0, 0.4) 30%,
        rgba(0, 0, 0, 0.8) 100%
    );
    z-index: 2;
}

.hero-content-wrapper {
    position: relative;
    z-index: 3;
    height: 100%;
    display: flex;
    align-items: flex-end;
    color: white;
    padding-bottom: 4rem;
}

/* Badges */
.detail-badges {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.badge-category, .badge-region, .badge-language {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    transition: var(--transition);
}

.badge-category {
    background: rgba(79, 70, 229, 0.9);
    border: 1px solid rgba(99, 102, 241, 0.3);
}

.badge-region {
    background: rgba(31, 41, 55, 0.8);
    border: 1px solid rgba(55, 65, 81, 0.3);
}

.badge-language {
    background: rgba(245, 158, 11, 0.9);
    border: 1px solid rgba(252, 211, 77, 0.3);
}

.badge-category:hover, .badge-region:hover, .badge-language:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Titre */
.detail-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 2rem;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, #fff 0%, #e0e7ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Auteur */
.author-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    max-width: 400px;
}

.author-avatar-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.author-info {
    flex: 1;
}

.author-name {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.post-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    opacity: 0.9;
}

.post-meta i {
    margin-right: 0.375rem;
}

/* ========== MAIN CONTENT ========== */
.detail-main-section {
    padding-bottom: 5rem;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
}

/* Article Principal */
.main-article {
    background: white;
    border-radius: var(--radius-xl);
    padding: 3rem;
    box-shadow: var(--shadow-xl);
}

.article-introduction {
    margin-bottom: 3rem;
}

.intro-text {
    font-size: 1.125rem;
    line-height: 1.8;
    color: var(--dark-light);
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid var(--light-gray);
}

.article-stats {
    display: flex;
    gap: 2rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-gray);
    font-size: 0.875rem;
    font-weight: 500;
}

.stat-item i {
    color: var(--primary);
}

/* Paywall Section */
.paywall-section {
    margin: 3rem 0;
}

.paywall-card {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    border: 2px dashed var(--primary-light);
    border-radius: var(--radius-xl);
    padding: 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.paywall-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
}

.paywall-icon {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 1.5rem;
}

.paywall-content h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
}

.paywall-content p {
    color: var(--text-gray);
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.paywall-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2.5rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--dark);
    font-weight: 500;
}

.feature i {
    color: var(--success);
}

.paywall-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-premium, .btn-secondary {
    padding: 1rem 2rem;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    transition: var(--transition);
    text-decoration: none;
    min-width: 220px;
}

.btn-premium {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
}

.btn-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(79, 70, 229, 0.4);
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
}

.btn-premium small {
    display: block;
    font-size: 0.75rem;
    opacity: 0.9;
    font-weight: 400;
    margin-top: 0.25rem;
}

.btn-secondary {
    background: white;
    color: var(--primary);
    border: 2px solid var(--medium-gray);
}

.btn-secondary:hover {
    border-color: var(--primary);
    background: var(--light-gray);
    transform: translateY(-2px);
}

/* Gallery */
.gallery-section {
    margin-top: 4rem;
    padding-top: 3rem;
    border-top: 2px solid var(--light-gray);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
}

.gallery-item {
    border-radius: var(--radius-lg);
    overflow: hidden;
    position: relative;
}

.gallery-item-inner {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(79, 70, 229, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.gallery-item:hover .gallery-image {
    transform: scale(1.1);
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay i {
    color: white;
    font-size: 2rem;
}

/* ========== SIDEBAR ========== */
.article-sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.sidebar-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--medium-gray);
}

.sidebar-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--light-gray);
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--light-gray);
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-gray);
    font-size: 0.875rem;
    font-weight: 500;
}

.info-label i {
    color: var(--primary);
    width: 20px;
}

.info-value {
    color: var(--dark);
    font-weight: 600;
    font-size: 0.875rem;
}

/* Similar Articles */
.similar-articles {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.similar-article {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-radius: var(--radius-md);
    border: 1px solid var(--medium-gray);
    text-decoration: none;
    transition: var(--transition);
}

.similar-article:hover {
    border-color: var(--primary);
    background: var(--light-gray);
    transform: translateX(4px);
}

.similar-image {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    flex-shrink: 0;
}

.similar-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.similar-content {
    flex: 1;
}

.similar-content h5 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.similar-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.similar-type {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary);
    background: rgba(79, 70, 229, 0.1);
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
}

.similar-date {
    font-size: 0.75rem;
    color: var(--text-gray);
}

/* Share Buttons */
.share-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.share-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: var(--radius-md);
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.875rem;
    transition: var(--transition);
}

.share-facebook {
    background: #3b5998;
    color: white;
}

.share-twitter {
    background: #1da1f2;
    color: white;
}

.share-whatsapp {
    background: #25d366;
    color: white;
}

.share-copy {
    background: var(--dark);
    color: white;
    grid-column: span 2;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .article-sidebar {
        position: static;
    }
    
    .detail-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .detail-hero {
        height: 70vh;
        min-height: 500px;
        margin-bottom: 2rem;
    }
    
    .detail-title {
        font-size: 2rem;
    }
    
    .main-article {
        padding: 2rem;
    }
    
    .paywall-card {
        padding: 2rem;
    }
    
    .btn-premium, .btn-secondary {
        min-width: 100%;
    }
    
    .paywall-actions {
        flex-direction: column;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}

@media (max-width: 480px) {
    .detail-hero {
        height: 60vh;
        min-height: 400px;
    }
    
    .detail-title {
        font-size: 1.75rem;
    }
    
    .hero-content-wrapper {
        padding-bottom: 2rem;
    }
    
    .author-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .post-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .main-article {
        padding: 1.5rem;
    }
    
    .sidebar-card {
        padding: 1.5rem;
    }
}
</style>

<script>
// Fonctions de partage
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`, '_blank');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(document.title);
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(document.title);
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Lien copié dans le presse-papier !');
    }).catch(err => {
        console.error('Erreur de copie : ', err);
    });
}

// Fonction de déblocage
function unlockContent() {
    alert('Fonctionnalité de paiement à venir avec FedaPay !');
    // À implémenter : window.location.href = "/payment/{{ $contenu->id_contenu }}";
}

// Animations
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée des éléments
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observer les éléments à animer
    const animatedElements = document.querySelectorAll('.main-article, .sidebar-card, .gallery-item');
    animatedElements.forEach(el => {
        observer.observe(el);
    });
    
    // Prévenir la soumission de formulaire si nécessaire
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Logique de soumission ici
        });
    });
});
</script>
@endsection
