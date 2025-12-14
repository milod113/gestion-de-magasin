<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Vision - Gestion Intelligente de Stock Hospitalier</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* ✅ Palette Logo Stock Vision (Bleu / Cyan / Émeraude) */
            --primary: #1e40af;          /* bleu principal */
            --primary-light: #dbeafe;    /* bleu très clair */
            --primary-dark: #1e3a8a;     /* bleu foncé */

            --secondary: #06b6d4;        /* cyan */
            --secondary-light: #cffafe;  /* cyan clair */

            --accent: #10b981;           /* émeraude */
            --accent-light: #d1fae5;     /* émeraude clair */

            --white: #ffffff;
            --light-bg: #f0f9ff;         /* fond très léger bleu */
            --dark-bg: #0f172a;
            --dark-surface: #1e293b;

            --text-dark: #1e293b;
            --text-light: #64748b;
            --text-dark-inverse: #f1f5f9;
            --text-light-inverse: #cbd5e1;

            --border: #e0f2fe;           /* bordures bleues */
            --border-dark: #334155;

            --success: #10b981;          /* vert émeraude */
            --warning: #f59e0b;          /* orange */
            --error: #ef4444;            /* rouge pour alertes */

            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-dark: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --shadow-dark-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--white);
            overflow-x: hidden;
        }

        body.dark-mode {
            background: var(--dark-bg);
            color: var(--text-dark-inverse);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }

        body.dark-mode header {
            background: rgba(15, 23, 42, 0.9);
            box-shadow: var(--shadow-dark);
            border-bottom: 1px solid var(--border-dark);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        body.dark-mode .logo {
            color: var(--secondary);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: var(--shadow);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        body.dark-mode .nav-links a {
            color: var(--text-dark-inverse);
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        body.dark-mode .nav-links a:hover {
            color: var(--secondary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
            color: white;
        }

        .btn-primary:hover {
            filter: brightness(0.95);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        body.dark-mode .btn-outline {
            border-color: var(--secondary);
            color: var(--secondary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        body.dark-mode .btn-outline:hover {
            background: var(--secondary);
            color: var(--dark-bg);
        }

        .btn-theme {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-bg);
            border: 1px solid var(--border);
            color: var(--text-dark);
            cursor: pointer;
        }

        body.dark-mode .btn-theme {
            background: var(--dark-surface);
            border-color: var(--border-dark);
            color: var(--text-dark-inverse);
        }

        .btn-theme:hover {
            background: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--white) 55%, var(--secondary-light) 100%);
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .hero {
            background: linear-gradient(135deg, #0c1b3a 0%, #0f172a 70%);
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary) 40%, var(--secondary) 80%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body.dark-mode .hero-text h1 {
            background: linear-gradient(135deg, var(--text-dark-inverse) 0%, var(--secondary) 50%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        body.dark-mode .hero-text p {
            color: var(--text-light-inverse);
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
        }

        .hero-visual {
            background: var(--white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            transform: perspective(1000px) rotateY(-5deg);
            border: 1px solid var(--border);
        }

        body.dark-mode .hero-visual {
            background: var(--dark-surface);
            border-color: var(--border-dark);
            box-shadow: var(--shadow-dark-lg);
        }

        .stock-card {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary);
            transition: transform 0.3s;
        }

        body.dark-mode .stock-card {
            background: rgba(30, 41, 59, 0.5);
            border-left-color: var(--secondary);
        }

        .stock-card.low {
            border-left-color: var(--error);
            background: #fee2e2;
        }
        body.dark-mode .stock-card.low {
            background: rgba(239, 68, 68, 0.15);
        }

        .stock-card.replenished {
            border-left-color: var(--accent);
            background: #d1fae5;
        }
        body.dark-mode .stock-card.replenished {
            background: rgba(16, 185, 129, 0.15);
        }

        .stock-card:hover {
            transform: translateX(5px);
        }

        .stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .stock-item {
            font-weight: 600;
            color: var(--text-dark);
        }

        body.dark-mode .stock-item {
            color: var(--text-dark-inverse);
        }

        .stock-status {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        body.dark-mode .stock-status {
            color: var(--text-light-inverse);
        }

        .stock-details {
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        body.dark-mode .stock-details {
            color: var(--text-dark-inverse);
        }

        .stock-level {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .level-critical {
            background: var(--error);
            color: white;
        }

        .level-warning {
            background: var(--warning);
            color: white;
        }

        .level-good {
            background: var(--accent);
            color: white;
        }

        /* Features Grid */
        .features {
            padding: 80px 0;
            background: var(--white);
        }

        body.dark-mode .features {
            background: var(--dark-bg);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        body.dark-mode .section-header h2 {
            color: var(--text-dark-inverse);
        }

        .section-header p {
            font-size: 1.125rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        body.dark-mode .section-header p {
            color: var(--text-light-inverse);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        body.dark-mode .feature-card {
            background: var(--dark-surface);
            border-color: var(--border-dark);
            box-shadow: var(--shadow-dark);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        body.dark-mode .feature-card:hover {
            box-shadow: var(--shadow-dark-lg);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--primary);
            font-size: 2rem;
            transition: transform 0.3s;
        }

        body.dark-mode .feature-icon {
            background: rgba(30, 64, 175, 0.15);
            color: var(--secondary);
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        body.dark-mode .feature-card h3 {
            color: var(--text-dark-inverse);
        }

        .feature-card p {
            color: var(--text-light);
            line-height: 1.6;
        }

        body.dark-mode .feature-card p {
            color: var(--text-light-inverse);
        }

        /* Analytics Section */
        .analytics {
            padding: 80px 0;
            background: var(--light-bg);
        }

        body.dark-mode .analytics {
            background: var(--dark-surface);
        }

        .analytics-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .analytics-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--secondary-light);
            color: #0e7490;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        body.dark-mode .analytics-badge {
            background: rgba(6, 182, 212, 0.2);
            color: var(--secondary);
        }

        .analytics h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        }

        body.dark-mode .analytics h2 {
            color: var(--text-dark-inverse);
        }

        .analytics p {
            font-size: 1.125rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        body.dark-mode .analytics p {
            color: var(--text-light-inverse);
        }

        .analytics-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .analytics-feature {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .analytics-feature i {
            color: var(--success);
            font-size: 1.25rem;
        }

        .analytics-visual {
            position: relative;
        }

        .analytics-chart {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--accent) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 4rem;
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.35);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background: var(--white);
        }

        body.dark-mode .testimonials {
            background: var(--dark-bg);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.3s;
            position: relative;
        }

        body.dark-mode .testimonial-card {
            background: var(--dark-surface);
            border-color: var(--border-dark);
            box-shadow: var(--shadow-dark);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-light);
        }

        body.dark-mode .testimonial-avatar {
            border-color: var(--primary);
        }

        .testimonial-info h4 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        body.dark-mode .testimonial-info h4 {
            color: var(--text-dark-inverse);
        }

        .testimonial-info p {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        body.dark-mode .testimonial-info p {
            color: var(--text-light-inverse);
        }

        .testimonial-quote {
            color: var(--text-dark);
            font-style: italic;
            line-height: 1.6;
            position: relative;
        }

        body.dark-mode .testimonial-quote {
            color: var(--text-dark-inverse);
        }

        .testimonial-quote::before {
            content: '"';
            font-size: 3rem;
            color: var(--primary-light);
            position: absolute;
            top: -1rem;
            left: -0.5rem;
            z-index: -1;
        }

        body.dark-mode .testimonial-quote::before {
            color: var(--primary);
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 60%, var(--accent) 100%);
            color: white;
            text-align: center;
        }

        body.dark-mode .cta {
            background: linear-gradient(135deg, #0c1b3a 0%, #0c4a6e 55%, #064e3b 100%);
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-white {
            background: white;
            color: var(--primary);
        }

        .btn-white:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-light {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-light:hover {
            background: white;
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: #121212;
            color: white;
            padding: 60px 0 20px;
        }

        body.dark-mode footer {
            background: #0a0f1c;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s, transform 0.3s;
        }

        .social-link:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        .footer-column h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content,
            .analytics-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .hero-buttons,
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-text h1 {
                font-size: 2rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .features-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="nav-container">
                <a href="#" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    Stock Vision
                </a>
                <ul class="nav-links">
                    <li><a href="#features">Fonctionnalités</a></li>
                    <li><a href="#analytics">Analytics</a></li>
                    <li><a href="#testimonials">Témoignages</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="/login" class="btn btn-outline">Connexion</a>
                    <a href="/register" class="btn btn-primary">Essai Gratuit</a>
                    <button id="theme-toggle" class="btn-theme" title="Changer le thème">
                        <i id="theme-icon" class="fas fa-moon"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Gestion Intelligente<br>de Stock Hospitalier</h1>
                    <p>La plateforme de gestion de stock conçue spécifiquement pour les environnements hospitaliers. Suivez, analysez et optimisez vos stocks médicaux en temps réel.</p>
                    <div class="hero-buttons">
                        <a href="/register" class="btn btn-primary">
                            <i class="fas fa-play-circle"></i>
                            Démarrer l'essai
                        </a>
                        <a href="#features" class="btn btn-outline">
                            <i class="fas fa-search"></i>
                            En savoir plus
                        </a>
                    </div>
                </div>

                <div class="hero-image" dir="rtl">
                    <div class="hero-visual">
                        <div class="stock-card">
                            <div class="stock-header">
                                <span class="stock-item">Médicaments : Paracétamol 1g</span>
                                <span class="stock-status">Mise à jour: 08:42</span>
                            </div>
                            <div class="stock-details">
                                Stock actuel: 350 unités - Seuil minimum: 500 unités
                            </div>
                            <div class="stock-level level-critical">
                                <i class="fas fa-exclamation-triangle"></i>
                                Niveau critique
                            </div>
                        </div>

                        <div class="stock-card">
                            <div class="stock-header">
                                <span class="stock-item">Matériel : Gants chirurgicaux</span>
                                <span class="stock-status">Mise à jour: 07:55</span>
                            </div>
                            <div class="stock-details">
                                Stock actuel: 1,200 paires - Consommation moyenne: 150/jour
                            </div>
                            <div class="stock-level level-warning">
                                <i class="fas fa-clock"></i>
                                Réapprovisionnement dans 2 jours
                            </div>
                        </div>

                        <div class="stock-card low">
                            <div class="stock-header">
                                <span class="stock-item">Consommables : Masques FFP2</span>
                                <span class="stock-status">Alert: 07:20</span>
                            </div>
                            <div class="stock-details">
                                Stock actuel: 150 unités - Commande en cours: 2,000 unités
                            </div>
                            <div class="stock-level level-critical">
                                <i class="fas fa-bell"></i>
                                URGENT: Réapprovisionner
                            </div>
                        </div>

                        <div class="stock-card replenished">
                            <div class="stock-header">
                                <span class="stock-item">Dispositifs : Seringues 10ml</span>
                                <span class="stock-status">Mis à jour: 07:10</span>
                            </div>
                            <div class="stock-details">
                                Stock actuel: 5,000 unités - Réception: 3,000 unités
                            </div>
                            <div class="stock-level level-good">
                                <i class="fas fa-check-circle"></i>
                                Stock optimal
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Découvrez les Fonctions Clés de Stock Vision</h2>
                <p>Une solution complète pour la gestion, le suivi et l'optimisation des stocks hospitaliers</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <h3>Gestion Centralisée des Stocks</h3>
                    <p>Suivez tous vos produits médicaux, médicaments et dispositifs dans une interface unifiée avec codes-barres et QR codes.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Alertes Intelligentes</h3>
                    <p>Recevez des notifications automatiques pour les stocks bas, dates de péremption approchantes et commandes à renouveler.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics en Temps Réel</h3>
                    <p>Visualisez la consommation, les tendances et les prévisions de stock avec des tableaux de bord interactifs.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h3>Gestion des Commandes</h3>
                    <p>Automatisez les commandes de réapprovisionnement et suivez les bons de commande avec les fournisseurs.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Sécurité et Traçabilité</h3>
                    <p>Authentification renforcée, contrôle des accès et traçabilité complète des mouvements de stock.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Application Mobile</h3>
                    <p>Gérez vos stocks depuis votre smartphone ou tablette avec l'application mobile dédiée.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Analytics Section -->
    <section class="analytics" id="analytics">
        <div class="container">
            <div class="analytics-content">
                <div>
                    <div class="analytics-badge">
                        <i class="fas fa-chart-pie"></i> Analytics avancés
                    </div>
                    <h2>Optimisez vos stocks avec l'intelligence artificielle</h2>
                    <p>
                        Stock Vision utilise des algorithmes d'IA pour prédire les besoins futurs,
                        optimiser les niveaux de stock et réduire les ruptures tout en minimisant les coûts.
                    </p>
                    <div class="analytics-features">
                        <div class="analytics-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Prévisions de consommation basées sur l'historique</span>
                        </div>
                        <div class="analytics-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Optimisation automatique des niveaux de stock</span>
                        </div>
                        <div class="analytics-feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Rapports personnalisables et exportables</span>
                        </div>
                    </div>
                </div>
                <div class="analytics-visual">
                    <div class="analytics-chart">
                        <i class="fas fa-brain"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>Ils Utilisent Stock Vision</h2>
                <p>Les responsables du CHU de Tlemcen témoignent de l'impact de Stock Vision sur la gestion des stocks</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="{{ asset('storage/testimonials/pharmacist.jpg') }}"
                             alt="Dr. Pharmacie CHU" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>Dr. Pharmacie CHU</h4>
                            <p>Pharmacien Responsable – Pharmacie Centrale</p>
                        </div>
                    </div>
                    <div class="testimonial-quote">
                        "Grâce à Stock Vision, nous avons réduit les ruptures de stock de 80% et optimisé nos commandes.
                        La traçabilité complète nous permet de gérer les lots et dates de péremption efficacement."
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="{{ asset('storage/testimonials/logistics.jpg') }}"
                             alt="M. Directeur Logistique" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>M. Directeur Logistique</h4>
                            <p>Directeur Logistique et Approvisionnement</p>
                        </div>
                    </div>
                    <div class="testimonial-quote">
                        "Stock Vision a révolutionné notre gestion logistique.
                        Les alertes automatiques et les prévisions nous permettent d'anticiper les besoins
                        et de négocier de meilleurs prix avec nos fournisseurs."
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="{{ asset('storage/testimonials/manager.jpg') }}"
                             alt="M. Directeur CHU" class="testimonial-avatar">
                        <div class="testimonial-info">
                            <h4>M. Directeur CHU</h4>
                            <p>Directeur Général du CHU de Tlemcen</p>
                        </div>
                    </div>
                    <div class="testimonial-quote">
                        "Stock Vision représente un gain de temps et d'argent considérable pour notre établissement.
                        La gestion centralisée et les analytics nous ont permis de réduire les stocks dormants de 60%."
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Prêt à Optimiser Votre Gestion de Stock Hospitalier ?</h2>
            <p>Rejoignez les établissements de santé qui ont déjà transformé leur gestion logistique avec Stock Vision</p>
            <div class="cta-buttons">
                <a href="/register" class="btn btn-white">
                    <i class="fas fa-calendar-check"></i>
                    Demander une démo
                </a>
                <a href="" class="btn btn-light">
                    <i class="fas fa-phone-alt"></i>
                    Nous contacter
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        Stock Vision
                    </div>
                    <p class="footer-description">
                        Plateforme de gestion de stock intelligente dédiée aux établissements hospitaliers et professionnels de santé.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Produit</h3>
                    <ul class="footer-links">
                        <li><a href="#">Fonctionnalités</a></li>
                        <li><a href="#">Analytics</a></li>
                        <li><a href="#">Tarifs</a></li>
                        <li><a href="#">Documentation</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Entreprise</h3>
                    <ul class="footer-links">
                        <li><a href="#">À propos</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Presse</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Légal</h3>
                    <ul class="footer-links">
                        <li><a href="#">Confidentialité</a></li>
                        <li><a href="#">Conditions</a></li>
                        <li><a href="#">RGPD</a></li>
                        <li><a href="#">Hébergement des données de santé</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Stock Vision. Solution développée par Ingénieur Embarki Miloud. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        // Charger le thème depuis le localStorage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-mode');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        // Changer le thème au clic
        toggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            themeIcon.classList.toggle('fa-moon', !isDark);
            themeIcon.classList.toggle('fa-sun', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });

        // Animation au défilement
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .testimonial-card, .stock-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>