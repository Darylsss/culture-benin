<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patrimoine Bénin')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        

        :root {
            --primary: #1E40AF; /* Bleu profond */
            --primary-light: #3B82F6; /* Bleu vif */
            --primary-dark: #1E3A8A;
            --accent: #F59E0B; /* Or ambré */
            --accent-light: #FCD34D;
            --dark: #0F172A;
            --light: #FFFFFF;
            --gray: #64748B;
            --gray-light: #E2E8F0;
            --border: #CBD5E1;
            --bg-subtle: #F8FAFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--dark);
            line-height: 1.6;
            background: var(--light);
        }

        /* Header Moderne avec Glassmorphism */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(203, 213, 225, 0.3);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            border-bottom-color: rgba(203, 213, 225, 0.5);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 85px;
        }

        /* Logo avec Masque Africain Stylisé */
        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--dark);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo:hover .logo-icon {
            transform: rotate(5deg);
        }

        .logo-icon {
            position: relative;
            width: 48px;
            height: 48px;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Masque Africain SVG Stylisé */
        .african-mask {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 2px 8px rgba(30, 64, 175, 0.2));
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .logo-title {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .logo-subtitle {
            font-size: 11px;
            font-weight: 500;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Navigation Moderne */
        .nav {
            display: flex;
            align-items: center;
            gap: 48px;
        }

        .nav-menu {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--dark);
            font-weight: 600;
            font-size: 15px;
            padding: 10px 4px;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
            transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Auth Buttons - Design Premium */
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        /* Bouton Connexion - Style Subtle */
        .btn-login {
            background: var(--bg-subtle);
            color: var(--primary);
            border: 2px solid var(--border);
        }

        .btn-login:hover {
            background: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.15);
        }

        /* Bouton Créer un compte - Gradient Premium */
        .btn-signup {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .btn-signup:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
        }

        /* User Menu Premium */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 8px 16px 8px 8px;
            background: var(--bg-subtle);
            border-radius: 50px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-menu:hover {
            background: white;
            border-color: var(--primary-light);
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.15);
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 2px 10px rgba(30, 64, 175, 0.2);
        }

        .user-name {
            font-weight: 600;
            font-size: 15px;
            color: var(--dark);
        }

        /* Main Content */
        .main-content {
            margin-top: 85px;
            min-height: calc(100vh - 85px);
        }

        /* Effet de particules décoratives */
        .header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                var(--accent) 25%, 
                var(--primary) 50%, 
                var(--accent) 75%, 
                transparent 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .header.scrolled::after {
            opacity: 0.6;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 20px;
                height: 70px;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
            }

            .logo-title {
                font-size: 18px;
            }

            .logo-subtitle {
                font-size: 9px;
            }

            .nav-menu {
                display: none;
            }

            .auth-buttons {
                gap: 8px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 13px;
            }

            .user-name {
                display: none;
            }
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        .header {
            animation: fadeInDown 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .logo-icon:hover .african-mask {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Indicateur de page active */
        .nav-link.active {
            color: var(--primary);
        }

        .nav-link.active::after {
            width: 100%;
        }

        /* ========== HERO CAROUSEL ========== */
        .hero-section {
            position: relative;
            height: calc(100vh - 85px);
            min-height: 700px;
            max-height: 900px;
            margin-top: 0;
            overflow: hidden;
        }

        /* Carousel Container */
        .hero-carousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .carousel-track {
            display: flex;
            height: 100%;
            transition: transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hero-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 30%;
            transition: transform 1.5s ease;
        }

        .hero-slide.active .hero-image {
            transform: scale(1.05);
        }

        /* Overlay sombre pour meilleure lisibilité */
        .hero-slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, 
                rgba(15, 23, 42, 0.7) 0%,
                rgba(15, 23, 42, 0.5) 50%,
                rgba(15, 23, 42, 0.8) 100%);
            z-index: 2;
        }

        /* Contenu superposé */
        .hero-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 3;
            color: white;
            text-align: center;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            font-family: 'Playfair Display', serif;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            max-width: 800px;
            margin-bottom: 3rem;
            opacity: 0.9;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* Bouton Hero */
        .hero-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.4);
        }

        .hero-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(30, 64, 175, 0.6);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }

        /* Navigation du carousel */
        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .carousel-nav:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-50%) scale(1.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .carousel-prev {
            left: 40px;
        }

        .carousel-next {
            right: 40px;
        }

        /* Indicateurs */
        .carousel-dots {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 12px;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid transparent;
        }

        .dot:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: scale(1.3);
        }

        .dot.active {
            width: 40px;
            border-radius: 6px;
            background: linear-gradient(90deg, var(--accent-light), var(--accent));
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.5);
        }

        /* Compteur de slides */
        .slide-counter {
            position: absolute;
            bottom: 40px;
            right: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            color: white;
            z-index: 5;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Section de contenu après le hero */
        .content-section {
            padding: 80px 0;
            background: var(--light);
            position: relative;
            z-index: 2;
        }

        .section-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 50%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray);
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.25rem;
                padding: 0 40px;
            }
            
            .carousel-nav {
                width: 50px;
                height: 50px;
            }
            
            .carousel-prev {
                left: 20px;
            }
            
            .carousel-next {
                right: 20px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                height: calc(100vh - 70px);
                min-height: 600px;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.125rem;
                padding: 0 20px;
                margin-bottom: 2rem;
            }
            
            .hero-btn {
                padding: 1rem 2rem;
                font-size: 1rem;
            }
            
            .carousel-nav {
                width: 44px;
                height: 44px;
            }
            
            .carousel-prev {
                left: 15px;
            }
            
            .carousel-next {
                right: 15px;
            }
            
            .slide-counter {
                display: none;
            }
            
            .carousel-dots {
                bottom: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
        }

         /* ========== ALTERNATING CONTENT SECTIONS ========== */
    .alternating-sections {
        padding: 120px 0;
        background: var(--light);
        position: relative;
    }

    .alternating-sections::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border), transparent);
    }

    .alternating-section {
        padding: 100px 0;
    }

    .alternating-section:first-child {
        padding-top: 0;
    }

    .alternating-section::after {
        content: '';
        display: block;
        max-width: 1200px;
        margin: 100px auto 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border), transparent);
    }

    .alternating-section:last-child::after {
        display: none;
    }

    .section-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .section-content {
        overflow: hidden;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    .alternating-section.reverse .content-grid {
        grid-column: 2;
    }

    .alternating-section.reverse .content-grid > * {
        direction: ltr;
    }

    /* Image Container */
    .content-image {
        position: relative;
        height: 400px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .content-image:hover {
        transform: translateY(-8px);
    }

    .content-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .content-image:hover img {
        transform: scale(1.05);
    }

    .image-overlay-decoration {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: linear-gradient(to top, 
            rgba(15, 23, 42, 0.2) 0%, 
            rgba(15, 23, 42, 0.05) 30%, 
            transparent 60%);
        pointer-events: none;
    }

    /* Text Container */
    .content-text {
        padding: 0 20px;
    }

    .section-label {
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary);
        margin-bottom: 20px;
        position: relative;
        padding-left: 24px;
    }

    .section-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 2px;
        background: var(--accent);
        border-radius: 1px;
    }

    .section-heading {
        font-size: 42px;
        font-weight: 800;
        line-height: 1.1;
        color: var(--dark);
        margin-bottom: 24px;
        letter-spacing: -0.5px;
    }

    .section-description {
        font-size: 18px;
        line-height: 1.7;
        color: var(--gray);
        margin-bottom: 40px;
        font-weight: 400;
    }

    /* Link Styling */
    .section-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        padding: 12px 0;
        position: relative;
        transition: all 0.3s ease;
    }

    .section-link::after {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--accent);
        transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .section-link:hover {
        color: var(--primary-dark);
        gap: 16px;
    }

    .section-link:hover::after {
        width: 100%;
    }

    .section-link svg {
        transition: transform 0.3s ease;
    }

    .section-link:hover svg {
        transform: translateX(4px);
    }

    /* Decorative Elements */
    .content-image::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, 
            transparent 0%, 
            rgba(245, 158, 11, 0.1) 25%, 
            rgba(59, 130, 246, 0.1) 50%, 
            rgba(245, 158, 11, 0.1) 75%, 
            transparent 100%);
        border-radius: 25px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .content-image:hover::before {
        opacity: 1;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-grid {
            gap: 60px;
        }
        
        .section-heading {
            font-size: 36px;
        }
        
        .content-image {
            height: 500px;
        }
    }

    @media (max-width: 768px) {
        .alternating-sections {
            padding: 80px 0;
        }
        
        .alternating-section {
            padding: 60px 0;
        }
        
        .section-container {
            padding: 0 24px;
        }
        
        .content-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .alternating-section.reverse .content-grid {
            direction: ltr;
        }
        
        .content-image {
            height: 400px;
            order: 1;
        }
        
        .content-text {
            order: 2;
            padding: 0;
        }
        
        .section-heading {
            font-size: 32px;
        }
        
        .section-description {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .content-image {
            height: 300px;
        }
        
        .section-heading {
            font-size: 28px;
        }
        
        .section-label {
            font-size: 12px;
            letter-spacing: 1.5px;
        }
    }

    /* Animation on Scroll */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alternating-section {
        animation: fadeInUp 0.8s ease-out;
    }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header Premium -->
    <header class="header">
        <div class="header-container">
            <!-- Logo avec Masque Africain -->
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-icon">
                    <svg class="african-mask" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <!-- Masque africain stylisé -->
                        <defs>
                            <linearGradient id="maskGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#1E40AF;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#3B82F6;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#F59E0B;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#FCD34D;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Base du masque -->
                        <ellipse cx="50" cy="55" rx="32" ry="40" fill="url(#maskGradient)"/>
                        
                        <!-- Front décoratif -->
                        <path d="M 35 30 Q 50 25 65 30" stroke="url(#accentGradient)" stroke-width="3" fill="none" stroke-linecap="round"/>
                        
                        <!-- Yeux stylisés -->
                        <ellipse cx="38" cy="48" rx="6" ry="8" fill="white"/>
                        <ellipse cx="62" cy="48" rx="6" ry="8" fill="white"/>
                        <circle cx="38" cy="48" r="3" fill="#0F172A"/>
                        <circle cx="62" cy="48" r="3" fill="#0F172A"/>
                        
                        <!-- Nez tribal -->
                        <path d="M 50 52 L 48 62 L 52 62 Z" fill="url(#accentGradient)"/>
                        
                        <!-- Bouche -->
                        <path d="M 40 70 Q 50 75 60 70" stroke="url(#accentGradient)" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        
                        <!-- Motifs décoratifs -->
                        <circle cx="30" cy="40" r="2" fill="url(#accentGradient)"/>
                        <circle cx="70" cy="40" r="2" fill="url(#accentGradient)"/>
                        <circle cx="27" cy="55" r="2" fill="url(#accentGradient)"/>
                        <circle cx="73" cy="55" r="2" fill="url(#accentGradient)"/>
                        
                        <!-- Lignes tribales -->
                        <path d="M 35 80 L 35 85" stroke="url(#accentGradient)" stroke-width="2" stroke-linecap="round"/>
                        <path d="M 50 82 L 50 88" stroke="url(#accentGradient)" stroke-width="2" stroke-linecap="round"/>
                        <path d="M 65 80 L 65 85" stroke="url(#accentGradient)" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <span class="logo-title">Culture Bénin</span>
                    <span class="logo-subtitle">Patrimoine & Traditions</span>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="nav">
                <ul class="nav-menu">
                    <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Accueil</a></li>
                    <li><a href="{{ route('contenus.index') }}" class="nav-link {{ request()->is('contenus*') ? 'active' : '' }}">Contenus</a></li>
                    <li><a href="{{ route('regions.index') }}" class="nav-link {{ request()->is('regions*') ? 'active' : '' }}">Régions</a></li>
                    <li><a href="{{ route('langues.index') }}" class="nav-link {{ request()->is('langues*') ? 'active' : '' }}">Langues</a></li>
                   
            </nav>

            <!-- Authentification -->
            <div class="auth-buttons">
                @auth
                    <!-- Utilisateur connecté -->
                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                @else
                    <!-- Visiteur -->
                    <a href="{{ route('login') }}" class="btn btn-login">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-signup">
                        Créer un compte
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="main-content">
        @yield('content')
        
        <!-- Hero Carousel Section -->
        @if(request()->is('/'))
        <section class="hero-section">
            <!-- Carousel Container -->
            <div class="hero-carousel">
                <div class="carousel-track">
                    <!-- Image 1 -->
                    <div class="hero-slide active">
                        <img src="{{ asset('images/gallery/presidence.jpg') }}" alt="Culture Béninoise" class="hero-image">
                    </div>

                    <!-- Image 2 -->
                    <div class="hero-slide">
                        <img src="{{ asset('images/gallery/image1.jpg') }}" alt="Art Traditionnel" class="hero-image">
                    </div>

                    <!-- Image 3 -->
                    <div class="hero-slide">
                        <img src="{{ asset('images/gallery/vod1.jpg') }}" alt="Festivals" class="hero-image">
                    </div>

                    
                   
                </div>
            </div>

            <!-- Contenu superposé -->
            <div class="hero-content">
                <h1 class="hero-title">Explorez le Patrimoine Béninois</h1>
                <p class="hero-subtitle">Découvrez la richesse de notre culture à travers les histoires, recettes et traditions qui font l'âme du Bénin</p>
               
            </div>

            <!-- Navigation -->
            <button class="carousel-nav carousel-prev" onclick="slideCarousel(-1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <button class="carousel-nav carousel-next" onclick="slideCarousel(1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>

            <!-- Indicateurs -->
            <div class="carousel-dots" id="carouselDots"></div>

            <!-- Compteur -->
            <div class="slide-counter">
                <span id="currentSlide">1</span> / <span id="totalSlides">4</span>
            </div>
        </section>

        @endif

<!-- Section 1: Traditions & Cérémonies -->
<div class="alternating-section">
    <div class="section-container">
        <div class="section-content">
            <div class="content-grid">
                <div class="content-image">
                    <img src="{{ asset('images/gallery/sabre.jpg') }}" alt="Traditions Béninoises" loading="lazy">
                    <div class="image-overlay-decoration"></div>
                </div>
                <div class="content-text">
                    <span class="section-label">Patrimoine Vivant</span>
                    <h2 class="section-heading">Traditions & Cérémonies</h2>
                    <p class="section-description">
                        Découvrez les rites ancestraux et cérémonies traditionnelles qui continuent de rythmer la vie des communautés béninoises. Du vodun aux festivals annuels, chaque pratique raconte une histoire unique.
                    </p>
                    <a href="{{ url('/contenus/traditions') }}" class="section-link">
                        En apprendre plus
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 2: Artisanat Local -->
<div class="alternating-section reverse">
    <div class="section-container">
        <div class="section-content">
            <div class="content-grid">
                <div class="content-text">
                    <span class="section-label">Artisanat Local</span>
                    <h2 class="section-heading">Savoir-Faire Artisanal</h2>
                    <p class="section-description">
                        Explorez l'excellence de l'artisanat béninois : tissage, poterie, sculpture sur bois, et bijouterie traditionnelle. Chaque pièce est le fruit d'un savoir-faire transmis de génération en génération.
                    </p>
                    <a href="{{ url('/contenus/artisanat') }}" class="section-link">
                        En apprendre plus
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
                <div class="content-image">
                    <img src="{{ asset('images/gallery/Autel.jpg') }}" alt="Artisanat Béninois" loading="lazy">
                    <div class="image-overlay-decoration"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 3: Gastronomie Traditionnelle -->
<div class="alternating-section">
    <div class="section-container">
        <div class="section-content">
            <div class="content-grid">
                <div class="content-image">
                    <img src="{{ asset('images/gallery/image7.jpg') }}" alt="Gastronomie Béninoise" loading="lazy">
                    <div class="image-overlay-decoration"></div>
                </div>
                <div class="content-text">
                    <span class="section-label">Savoirs Culinaires</span>
                    <h2 class="section-heading">Gastronomie Traditionnelle</h2>
                    <p class="section-description">
                        Goûtez à la richesse culinaire du Bénin : des plats emblématiques comme l'Atassi, le Gboma Dessi, et le Riz au Gras. Chaque recette est une invitation à découvrir l'histoire et la culture à travers la cuisine.
                    </p>
                    <a href="{{ url('/contenus/gastronomie') }}" class="section-link">
                        En apprendre plus
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Derniers Contenus -->
@include('partials.recent-contents')

    </main>

    <!-- Section 4: Identité Culturelle -->
<div class="alternating-section reverse">
    <div class="section-container">
        <div class="section-content">
            <div class="content-grid">
                <div class="content-text">
                    <span class="section-label">Notre ADN Culturel</span>
                    <h2 class="section-heading">Identité Culturelle</h2>
                    <p class="section-description">
                        L'identité béninoise est un riche tissu composé de traditions ancestrales, de valeurs 
                        communautaires et d'une histoire millénaire. C'est l'âme du Dahomey qui continue de battre 
                        à travers nos pratiques, nos croyances et notre vision du monde.
                    </p>
                    <div style="display: flex; gap: 20px; margin-top: 30px;">
                        <div style="flex: 1;">
                            <h4 style="font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Valeurs</h4>
                            <p style="color: var(--gray); font-size: 14px;">Communauté, Respect des Ancêtres, Sagesse Traditionnelle</p>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Héritage</h4>
                            <p style="color: var(--gray); font-size: 14px;">Royaume du Dahomey, Route de l'Esclave, Cités Royales</p>
                        </div>
                    </div>
                </div>
                <div class="content-image">
                    <img src="{{ asset('images/gallery/image8.jpg') }}" alt="Identité Culturelle Béninoise" loading="lazy">
                    <div class="image-overlay-decoration"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 5: La Fierté d'un Peuple -->
<div class="alternating-section" style="background: linear-gradient(135deg, var(--bg-subtle) 0%, rgba(245, 158, 11, 0.05) 100%);">
    <div class="section-container">
        <div class="section-content">
            <div class="content-grid">
                <div class="content-image">
                    <img src="{{ asset('images/gallery/image4.jpg') }}" alt="Fierté du Peuple Béninois" loading="lazy">
                    <div class="image-overlay-decoration"></div>
                </div>
                <div class="content-text">
                    <span class="section-label">Notre Patrimoine</span>
                    <h2 class="section-heading">La Fierté d'un Peuple</h2>
                    <p class="section-description">
                        Le Bénin rayonne par sa culture qui inspire le monde entier. De Ouidah à Abomey, de 
                        Porto-Novo à Natitingou, chaque ville porte en elle la fierté d'un peuple résilient, 
                        créatif et profondément ancré dans ses traditions.
                    </p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 30px;">
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 800; color: var(--accent);">+200</div>
                            <div style="font-size: 14px; color: var(--gray);">Traditions Vivantes</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 800; color: var(--accent);">12</div>
                            <div style="font-size: 14px; color: var(--gray);">Patrimoines UNESCO</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 800; color: var(--accent);">56</div>
                            <div style="font-size: 14px; color: var(--gray);">Langues Nationales</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 32px; font-weight: 800; color: var(--accent);">∞</div>
                            <div style="font-size: 14px; color: var(--gray);">Histoires à Partager</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer style="
        background: var(--dark);
        color: white;
        padding: 60px 0 30px;
    ">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 32px;">
            <div style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 40px;
                margin-bottom: 40px;
            ">
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                        <div style="
                            width: 40px;
                            height: 40px;
                            background: linear-gradient(135deg, var(--primary), var(--accent));
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <i class="fas fa-landmark" style="color: white;"></i>
                        </div>
                        <span style="font-size: 20px; font-weight: 800;">Culture Bénin</span>
                    </div>
                    <p style="color: rgba(255,255,255,0.7); line-height: 1.6;">
                        Plateforme numérique dédiée à la promotion et préservation des cultures et langues du Bénin.
                    </p>
                </div>
                
                <div>
                    <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Navigation</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px;">
                        <li><a href="{{ url('/') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">Accueil</a></li>
                        <li><a href="{{ route('contenus.index') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">Explorer</a></li>
                        <li><a href="{{ route('regions.index') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">Régions</a></li>
                        <li><a href="{{ route('langues.index') }}" style="color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s;">Langues</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Contact</h4>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-envelope" style="color: var(--accent);"></i>
                            <span style="color: rgba(255,255,255,0.7);">contact@mldbenin.bj</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-phone" style="color: var(--accent);"></i>
                            <span style="color: rgba(255,255,255,0.7);">+229 XX XX XX XX</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="
                border-top: 1px solid rgba(255,255,255,0.1);
                padding-top: 30px;
                text-align: center;
                color: rgba(255,255,255,0.5);
                font-size: 14px;
            ">
                &copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.
            </div>
        </div>
    </footer>

    <script>
        // Effet de scroll sur le header
        let lastScroll = 0;
        const header = document.querySelector('.header');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 30) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
        });

        // ========== HERO CAROUSEL FUNCTIONALITY ==========
        let currentSlide = 0;
        const track = document.querySelector('.carousel-track');
        const slides = document.querySelectorAll('.hero-slide');
        const totalSlides = slides.length;
        const dotsContainer = document.getElementById('carouselDots');
        const currentSlideElement = document.getElementById('currentSlide');
        const totalSlidesElement = document.getElementById('totalSlides');

        // Initialiser les éléments du carousel
        if (track && slides.length > 0) {
            // Mettre à jour le compteur total
            if (totalSlidesElement) {
                totalSlidesElement.textContent = totalSlides;
            }

            // Créer les dots dynamiquement
            if (dotsContainer) {
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('span');
                    dot.className = 'dot' + (i === 0 ? ' active' : '');
                    dot.onclick = () => goToSlide(i);
                    dotsContainer.appendChild(dot);
                }
            }

            const dots = document.querySelectorAll('.dot');

            function updateCarousel() {
                // Mettre à jour la position du track
                const offset = -currentSlide * 100;
                track.style.transform = `translateX(${offset}%)`;

                // Mettre à jour les classes actives des slides
                slides.forEach((slide, index) => {
                    slide.classList.toggle('active', index === currentSlide);
                });

                // Mettre à jour les dots
                if (dots) {
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === currentSlide);
                    });
                }

                // Mettre à jour le compteur
                if (currentSlideElement) {
                    currentSlideElement.textContent = currentSlide + 1;
                }
            }

            function slideCarousel(direction) {
                currentSlide += direction;
                
                if (currentSlide < 0) {
                    currentSlide = totalSlides - 1;
                } else if (currentSlide >= totalSlides) {
                    currentSlide = 0;
                }
                
                updateCarousel();
            }

            function goToSlide(index) {
                currentSlide = index;
                updateCarousel();
            }

            // Auto-play carousel
            let autoplayInterval = setInterval(() => {
                slideCarousel(1);
            }, 5000);

            // Pause autoplay on hover
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.addEventListener('mouseenter', () => {
                    clearInterval(autoplayInterval);
                });

                heroSection.addEventListener('mouseleave', () => {
                    autoplayInterval = setInterval(() => {
                        slideCarousel(1);
                    }, 5000);
                });

                // Swipe support pour mobile
                let touchStartX = 0;
                let touchEndX = 0;

                heroSection.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                });

                heroSection.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });

                function handleSwipe() {
                    if (touchEndX < touchStartX - 50) {
                        slideCarousel(1);
                    }
                    if (touchEndX > touchStartX + 50) {
                        slideCarousel(-1);
                    }
                }
            }

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    slideCarousel(-1);
                } else if (e.key === 'ArrowRight') {
                    slideCarousel(1);
                }
            });

            // Initialiser le carousel
            updateCarousel();
        }

         // Animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.alternating-section');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });
        
        sections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(section);
        });
    });

            // ========== ALTERNATING SECTIONS ANIMATION ==========
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.alternating-section');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });
            
            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(section);
            });
        });
    </script>
    
    @stack('scripts')
</body> 
</html>