<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | DataCenter</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-overlay: rgba(15, 23, 42, 0.6); /* Sombre et élégant */
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --accent: #3b82f6; 
            --accent-hover: #2563eb;
            --font-main: 'Inter', sans-serif;
            --font-heading: 'Instrument Sans', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: var(--font-main); }

        body {
            background-color: #0f172a;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden !important; /* Pas de scroll */
        }

        /* Background Image (Matches Welcome Page) */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("{{ asset('images/bg-tech.png') }}"); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px) brightness(0.4);
            transform: scale(1.05);
            z-index: -1;
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

        .login-container {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 10;
            animation: fadeIn 0.8s ease-out;
        }

        .card {
            background: rgba(15, 23, 42, 0.75); /* Plus opaque pour la lisibilité */
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        /* Ligne lumineuse en haut */
        .card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
            margin-bottom: 24px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
        }

        h1 {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: white;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
            margin-left: 2px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            color: white;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            transition: all 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        button:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .links {
            margin-top: 24px;
            font-size: 13px;
        }

        .links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .links a:hover {
            color: white;
            text-decoration: underline;
        }

        .divider {
            margin: 20px 0;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.2);
            font-size: 12px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        .divider span {
            padding: 0 10px;
        }

        /* Error Alert */
        .alert-error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="circle-bg"></div>

    <div class="login-container">
        <div class="card">
            
            <img src="{{ asset('images/logo-datacenter.jpg') }}" alt="Logo" class="logo">
            
            <h1>Bon retour</h1>
            <p>Connectez-vous pour accéder au DataCenter</p>

            @if ($errors->any())
                <div class="alert-error">
                    <ul style="list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                
                <div class="form-group">
                    <label>Email Professionnel</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nom@exemple.com" autocomplete="off">
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••" autocomplete="new-password">
                </div>

                <button type="submit">
                    Se connecter <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 12px;"></i>
                </button>
            </form>

            <div class="divider">
                <span>OU</span>
            </div>

            <div class="links">
                <p style="margin-bottom: 0;">Pas encore de compte ?</p>
                <a href="{{ route('demande.create') }}" style="color: var(--accent); font-weight: 500;">Demander un accès invité</a>
                <br><br>
                <a href="{{ url('/') }}">← Retour à l'accueil</a>
            </div>

        </div>
    </div>

</body>
</html>
