<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Manager</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .landing-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-align: center;
            background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
            animation: fadeIn 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 4rem;
            text-align: center;
            max-width: 600px;
            line-height: 1.6;
            animation: fadeIn 1s ease-out 0.2s backwards;
        }

        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            width: 100%;
            max-width: 1000px;
        }

        .action-card {
            background: rgba(18, 20, 26, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out backwards;
        }

        .action-card:nth-child(1) { animation-delay: 0.3s; }
        .action-card:nth-child(2) { animation-delay: 0.45s; }
        .action-card:nth-child(3) { animation-delay: 0.6s; }

        .action-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, var(--accent-glow), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }

        .action-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent);
        }

        .action-card:hover::before {
            opacity: 0.2;
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            border: 1px solid var(--border);
            transition: 0.4s;
        }

        .action-card:hover .card-icon {
            background: var(--accent);
            color: white;
            box-shadow: 0 0 20px var(--accent-glow);
            border-color: transparent;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .card-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .circle-bg {
            position: fixed;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="circle-bg"></div>
    
    <div class="landing-container">
        <h1 class="hero-title">Data Center Manager</h1>
        <p class="hero-subtitle">
            Bienvenue sur votre plateforme de gestion centralisée. <br>
            Surveillez, gérez et optimisez vos ressources en toute simplicité.
        </p>

        <div class="action-cards">
            <!-- Login -->
            <a href="{{ route('login') }}" class="action-card">
                <div class="card-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h2 class="card-title">Connexion</h2>
                <p class="card-desc">Accédez à votre espace administrateur ou responsable pour gérer les ressources.</p>
            </a>

            <!-- Create Account -->
            <a href="{{ route('demande.create') }}" class="action-card">
                <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="card-title">Demander un Compte</h2>
                <p class="card-desc">Vous n'avez pas d'accès ? Soumettez une demande de création de compte.</p>
            </a>

            <!-- Guest -->
            <a href="{{ route('espace.invite') }}" class="action-card">
                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h2 class="card-title">Espace Invité</h2>
                <p class="card-desc">Consultez la disponibilité publique de nos serveurs et équipements.</p>
            </a>
        </div>
    </div>
</body>
</html>
