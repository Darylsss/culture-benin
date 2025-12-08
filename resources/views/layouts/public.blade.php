<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Culture Bénin')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
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
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        /* Header Public */
        .public-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--medium-gray);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: var(--light-gray);
            color: var(--primary) !important;
        }

        /* Main Content */
        .public-content {
            min-height: calc(100vh - 140px);
            padding: 2rem 0;
        }

        /* Footer */
        .public-footer {
            background: var(--dark);
            color: white;
            padding: 3rem 0 1.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .public-content {
                padding: 1rem 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header Public -->
    <header class="public-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   
                    Culture Bénin
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i>
                                Accueil
                            </a>
                        </li>
                       
                       
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>
                                    Connexion
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>
                                    Inscription
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenu Principal -->
    <main class="public-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="public-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Culture Bénin</h5>
                    <p class="text-muted">
                        Plateforme numérique dédiée à la promotion et préservation des cultures et langues du Bénin.
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Navigation</h5>
                    <div class="footer-links">
                        <a href="{{ url('/') }}" class="d-block mb-2">Accueil</a>
                        <a href="{{ route('contenus.index') }}" class="d-block mb-2">Articles</a>
                        <a href="{{ route('regions.index') }}" class="d-block mb-2">Régions</a>
                        <a href="{{ route('langues.index') }}" class="d-block mb-2">Langues</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Contact</h5>
                    <div class="footer-links">
                        <a href="mailto:contact@mldbenin.bj" class="d-block mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            contact@mldbenin.bj
                        </a>
                        <div class="mt-3">
                            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-muted">
                &copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.
            </div>
        </div>
    </footer>

   
    
    @stack('scripts')
</body>
</html>