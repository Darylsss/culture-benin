@if($recentContents && $recentContents->count() > 0)
<section class="recent-contents-modern">
    <div class="modern-container">
        <div class="modern-header">
            <div class="header-content">
                <h2 class="modern-title">Derniers Contenus</h2>
                <p class="modern-subtitle">Explorez les contenus culturels récemment publiés</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('contenus.index') }}" class="modern-view-all">
                    Voir tout
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="modern-grid">
            @foreach($recentContents as $content)
            <article class="modern-card">
                <!-- Badge supérieur -->
                <div class="card-badge-top">
                    <span class="category-badge">{{ $content->typeContenu->nom_contenu ?? 'Général' }}</span>
                    <span class="region-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        {{ $content->region->nom_region ?? 'N/A' }}
                    </span>
                </div>
                
                <!-- Image avec effet hover -->
                <div class="card-media">
                    @if($content->medias && $content->medias->count() > 0)
                    <div class="media-wrapper">
                        <img src="{{ asset($content->medias->first()->chemin) }}" 
                             alt="{{ $content->titre }}" 
                             class="card-image"
                             loading="lazy">
                        <div class="media-overlay">
                            <div class="play-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="media-placeholder">
                        <div class="placeholder-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Badge de langue -->
                    <div class="language-badge">
                        <span class="language-code">{{ substr($content->langue->nom_langue ?? 'FR', 0, 2) }}</span>
                    </div>
                </div>
                
                <!-- Contenu texte -->
                <div class="card-body">
                    <div class="card-meta">
                        <div class="author-info">
                            <div class="author-avatar">
                                <span>{{ strtoupper(substr($content->auteur->prenom ?? 'A', 0, 1)) }}</span>
                            </div>
                            <div class="author-details">
                                <span class="author-name">{{ $content->auteur->prenom ?? 'Anonyme' }}</span>
                                <span class="post-date">{{ \Carbon\Carbon::parse($content->date_creation)->format('d M') }}</span>
                            </div>
                        </div>
                        <div class="interaction-stats">
                            <div class="stat-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>{{ rand(50, 500) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="card-title">
                        <a href="{{ route('contenus.show', $content) }}" class="title-link">
                            {{ Illuminate\Support\Str::limit($content->titre, 50) }}
                        </a>
                    </h3>
                    
                    <p class="card-excerpt">
                        {{ Illuminate\Support\Str::limit(strip_tags($content->texte), 90) }}
                    </p>
                    
                    <div class="card-footer">
                        <a href="{{ route('contenus.show', $content) }}" class="read-more">
                            Lire l'article
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                        <div class="action-buttons">
                            <button class="action-btn save-btn" title="Enregistrer">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </button>
                            <button class="action-btn share-btn" title="Partager">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <!-- Navigation dots (pour mobile) -->
        <div class="mobile-nav">
            @for($i = 0; $i < min(4, $recentContents->count()); $i++)
            <span class="nav-dot"></span>
            @endfor
        </div>
    </div>
</section>

<style>
/* ========== MODERN RECENT CONTENTS ========== */
.recent-contents-modern {
    padding: 80px 0;
    background: var(--light);
    background-color: #09111cff;
    position: relative;
    overflow: hidden;
}

.recent-contents-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(30, 64, 175, 0.1) 25%, 
        rgba(30, 64, 175, 0.3) 50%, 
        rgba(175, 119, 30, 0.1) 75%, 
        transparent 100%);
}

.modern-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Header */
.modern-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 60px;
    gap: 24px;
}

.header-content {
    flex: 1;
}

.modern-title {
    font-size: 2.75rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
    line-height: 1.1;
}

.modern-subtitle {
    font-size: 1.125rem;
    color: var(--gray);
    font-weight: 400;
    max-width: 500px;
    line-height: 1.6;
}

.modern-view-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--bg-subtle);
    border: 2px solid var(--border);
    border-radius: 12px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    white-space: nowrap;
}

.modern-view-all:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(30, 64, 175, 0.2);
}

.modern-view-all svg {
    transition: transform 0.3s ease;
}

.modern-view-all:hover svg {
    transform: translateX(4px);
}

/* Grid Layout */
.modern-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 32px;
    margin-bottom: 40px;
}

/* Card Styling */
.modern-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.modern-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
    border-color: rgba(30, 64, 175, 0.2);
}

/* Badge Top */
.card-badge-top {
    position: absolute;
    top: 16px;
    left: 16px;
    right: 16px;
    display: flex;
    justify-content: space-between;
    z-index: 2;
}

.category-badge {
    background: var(--primary);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    background: rgba(30, 64, 175, 0.95);
}

.region-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(15, 23, 42, 0.85);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

/* Media Section */
.card-media {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.media-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.modern-card:hover .card-image {
    transform: scale(1.08);
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, 
        rgba(15, 23, 42, 0) 0%,
        rgba(15, 23, 42, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modern-card:hover .media-overlay {
    opacity: 1;
}

.play-icon {
    background: rgba(255, 255, 255, 0.95);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.modern-card:hover .play-icon {
    transform: scale(1);
}

.media-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f4ff, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
}

.placeholder-icon {
    color: var(--gray-light);
}

.language-badge {
    position: absolute;
    bottom: -12px;
    right: 16px;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border: 2px solid var(--primary);
}

.language-code {
    font-size: 12px;
    font-weight: 800;
    color: var(--primary);
    text-transform: uppercase;
}

/* Card Body */
.card-body {
    padding: 32px 24px 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Meta Information */
.card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
}

.author-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.author-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--dark);
}

.post-date {
    font-size: 12px;
    color: var(--gray);
    font-weight: 500;
}

.interaction-stats {
    display: flex;
    gap: 16px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--gray);
    font-size: 13px;
    font-weight: 500;
}

.stat-item svg {
    stroke-width: 2.5;
}

/* Title and Excerpt */
.card-title {
    margin-bottom: 12px;
}

.title-link {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    text-decoration: none;
    line-height: 1.4;
    transition: color 0.3s ease;
    display: block;
}

.title-link:hover {
    color: var(--primary);
}

.card-excerpt {
    color: var(--gray);
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 24px;
    flex: 1;
}

/* Footer Actions */
.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid var(--gray-light);
}

.read-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.read-more:hover {
    gap: 12px;
    color: var(--primary-dark);
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-subtle);
    border: 1px solid var(--border);
    color: var(--gray);
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

/* Mobile Navigation */
.mobile-nav {
    display: none;
    justify-content: center;
    gap: 8px;
    margin-top: 32px;
}

.nav-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--border);
    transition: background 0.3s ease;
}

.nav-dot.active {
    background: var(--primary);
    width: 24px;
    border-radius: 4px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .modern-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    
    .modern-title {
        font-size: 2.25rem;
    }
}

@media (max-width: 768px) {
    .recent-contents-modern {
        padding: 60px 0;
    }
    
    .modern-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 40px;
    }
    
    .modern-title {
        font-size: 2rem;
    }
    
    .modern-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding: 0 0 20px;
        -webkit-overflow-scrolling: touch;
    }
    
    .modern-card {
        scroll-snap-align: start;
        min-width: 300px;
    }
    
    .mobile-nav {
        display: flex;
    }
    
    .modern-container {
        padding: 0 20px;
    }
}

@media (max-width: 480px) {
    .modern-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .modern-card {
        min-width: auto;
    }
    
    .modern-title {
        font-size: 1.75rem;
    }
    
    .card-media {
        height: 180px;
    }
}

/* Animation */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-card {
    animation: slideInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation-fill-mode: both;
}

/* Stagger animation */
.modern-card:nth-child(1) { animation-delay: 0.1s; }
.modern-card:nth-child(2) { animation-delay: 0.2s; }
.modern-card:nth-child(3) { animation-delay: 0.3s; }
.modern-card:nth-child(4) { animation-delay: 0.4s; }
.modern-card:nth-child(5) { animation-delay: 0.5s; }
.modern-card:nth-child(6) { animation-delay: 0.6s; }
.modern-card:nth-child(7) { animation-delay: 0.7s; }
.modern-card:nth-child(8) { animation-delay: 0.8s; }

/* Optional: Hover effect for the whole section */
.recent-contents-modern:hover .modern-card:not(:hover) {
    opacity: 0.7;
    transform: scale(0.98);
}
</style>

<script>
// Optional: Simple JavaScript for mobile navigation
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.modern-card');
    const dots = document.querySelectorAll('.nav-dot');
    
    if (window.innerWidth <= 768) {
        // Update active dot on scroll
        const grid = document.querySelector('.modern-grid');
        if (grid) {
            grid.addEventListener('scroll', function() {
                const scrollLeft = grid.scrollLeft;
                const cardWidth = cards[0]?.offsetWidth || 320;
                const gap = 24;
                const activeIndex = Math.round(scrollLeft / (cardWidth + gap));
                
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === activeIndex);
                });
            });
        }
    }
    
    // Add click handlers for action buttons
    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('saved');
            this.style.color = this.classList.contains('saved') ? 'var(--accent)' : '';
        });
    });
});
</script>
</section>
@endif