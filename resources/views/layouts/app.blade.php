<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Culture Bénin')</title>
    
    <!-- Font Awesome - Version stable -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    

    <style>
        :root {
            --primary: #1E40AF;
            --primary-light: #3B82F6;
            --primary-dark: #1E3A8A;
            --accent: #F59E0B;
            --accent-light: #FCD34D;
            --dark: #0F172A;
            --light: #FFFFFF;
            --gray: #64748B;
            --gray-light: #E2E8F0;
            --border: #CBD5E1;
            --bg-subtle: #F8FAFC;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        /* Fix pour Font Awesome */
        .fa, .fas, .far, .fal, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands" !important;
            font-weight: 900;
        }

        .fab {
            font-weight: 400;
        }

        body {
            background: var(--bg-subtle);
        }

        /* ========== NAVBAR MODERNISÉ ========== */
        .main-header.navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(203, 213, 225, 0.3);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            height: 70px;
            padding: 0 24px;
        }

        .navbar .nav-link {
            font-weight: 600;
            color: var(--dark) !important;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px !important;
        }

        .navbar .nav-link:hover {
            background: var(--bg-subtle);
            color: var(--primary) !important;
        }

        .navbar .nav-link i {
            font-size: 18px;
        }

        /* Dropdown modernisé */
        .navbar .dropdown-menu {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 8px;
            margin-top: 8px;
        }

        .navbar .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .navbar .dropdown-item:hover {
            background: var(--bg-subtle);
            color: var(--primary) !important;
        }

        /* ========== SIDEBAR MODERNISÉ ========== */
        .main-sidebar {
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%) !important;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.1);
        }

        /* Brand Link avec logo masque */
        .brand-link {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 20px 16px !important;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: rgba(255, 255, 255, 0.15) !important;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .brand-text {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: white !important;
            letter-spacing: -0.5px;
        }

        /* User Panel */
        .user-panel {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 16px !important;
            margin: 16px 12px !important;
        }

        .user-panel .image i {
            font-size: 36px;
            color: var(--accent-light);
        }

        .user-panel .info a {
            color: white !important;
            font-weight: 600;
            font-size: 15px;
        }

        /* Navigation Sidebar */
        .nav-sidebar .nav-item {
            margin: 4px 12px;
        }

        .nav-sidebar .nav-link {
            border-radius: 10px;
            padding: 12px 16px !important;
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent);
            transform: translateX(-4px);
            transition: transform 0.3s ease;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.12) !important;
            color: white !important;
            transform: translateX(4px);
        }

        .nav-sidebar .nav-link:hover::before {
            transform: translateX(0);
        }

        .nav-sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .nav-sidebar .nav-link.active::before {
            transform: translateX(0);
        }

        .nav-sidebar .nav-icon {
            font-size: 18px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        /* ========== CONTENT WRAPPER ========== */
        .content-wrapper {
            background: var(--bg-subtle) !important;
            min-height: calc(100vh - 70px);
            padding: 32px 24px;
        }

        /* Alerts modernisés */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            animation: slideInDown 0.4s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #EF4444 0%, #F87171 100%);
            color: white;
        }

        .alert .close {
            color: white;
            opacity: 0.8;
            font-size: 20px;
            font-weight: 300;
        }

        .alert .close:hover {
            opacity: 1;
        }

        /* ========== FOOTER ========== */
        .main-footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 20px 24px;
            color: var(--gray);
            font-size: 14px;
        }

        .main-footer strong {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        /* ========== CARDS & BOXES ========== */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 16px 16px 0 0 !important;
            padding: 20px 24px;
            border-bottom: none;
            font-weight: 600;
        }

        /* ========== BUTTONS ========== */
        .btn {
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10B981, #34D399);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444, #F87171);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        /* ========== FORMS ========== */
        .form-control {
            border-radius: 10px;
            border: 2px solid var(--border);
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        /* ========== TABLES ========== */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-weight: 600;
            border: none;
            padding: 16px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: var(--bg-subtle);
            transform: scale(1.01);
        }

        /* ========== ANIMATIONS ========== */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .content-wrapper {
            animation: fadeIn 0.5s ease-out;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px 16px;
            }

            .main-header.navbar {
                height: 60px;
                padding: 0 16px;
            }
        }

        /* Scrollbar personnalisée */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>


</head>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        
        <!-- Navbar Modernisé -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-2"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Inscription
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>

        <!-- Sidebar Modernisé -->
        @auth
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/dashboard') }}" class="brand-link">
                <span class="brand-icon">
                    <i class="fas fa-globe"></i>
                </span>
                <span class="brand-text">Culture Bénin</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle img-circle elevation-2"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Accueil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('langues.index') }}" class="nav-link {{ request()->is('langues*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-language"></i>
                                <p>Langues</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('regions.index') }}" class="nav-link {{ request()->is('regions*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <p>Régions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('type-contenus.index') }}" class="nav-link {{ request()->is('type-contenus*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Types de Contenu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('type-medias.index') }}" class="nav-link {{ request()->is('type-medias*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>Types de Média</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('utilisateurs.index') }}" class="nav-link {{ request()->is('utilisateurs*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Utilisateurs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>Rôles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contenus.index') }}" class="nav-link {{ request()->is('contenus*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Contenus</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('medias.index') }}" class="nav-link {{ request()->is('medias*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>Médias</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('commentaires.index') }}" class="nav-link {{ request()->is('commentaires*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>Commentaires</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        @endauth

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Culture Bénin &copy; 2024</strong> - Patrimoine et traditions
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    <script>
        // Animation des alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.animation = 'slideInDown 0.4s ease-out';
                }, 100);
            });
        });

        // Effet de hover sur les nav-links
        document.querySelectorAll('.nav-sidebar .nav-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            
            link.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateX(0)';
                }
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>