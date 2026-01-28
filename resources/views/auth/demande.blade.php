<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Ouverture de Compte | DataCenter</title>
    <!-- Modern Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #0f172a;
            --accent: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.4);
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --radius: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background-color: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Ambient Background Animations */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            filter: blur(80px);
            z-index: -1;
            animation: float 20s infinite ease-in-out;
        }
        body::before { top: -200px; left: -200px; animation-delay: 0s; }
        body::after { bottom: -200px; right: -200px; background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%); animation-delay: -10s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -50px) scale(1.1); }
        }

        .container {
            width: 100%;
            max-width: 480px;
            padding: 20px;
            perspective: 1000px;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) backwards;
            position: relative;
            overflow: hidden;
        }

        /* Top shine effect */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        h2 {
            color: var(--text-primary);
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            animation: fadeIn 0.5s ease backwards;
        }
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }
        .form-group:nth-child(4) { animation-delay: 0.5s; }

        label {
            display: block;
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 8px;
            font-weight: 500;
            margin-left: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1rem;
            transition: 0.3s;
        }

        input, select {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 14px 16px 14px 44px; /* Space for icon */
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

        select option {
            background: #1e293b;
            color: var(--text-primary);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        input:focus + i, select:focus + i {
            color: var(--accent);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--accent), #2563eb);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.6s ease backwards 0.6s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.5);
            filter: brightness(1.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
            opacity: 0.8;
            animation: fadeIn 0.8s ease backwards 0.8s;
        }

        .back-link:hover {
            color: var(--text-primary);
            opacity: 1;
            transform: translateX(-5px);
            display: inline-block;
        }

        /* Error & Success Messages */
        .notification {
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .notification.error { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
        .notification.success { background: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); height: 0; }
            to { opacity: 1; transform: translateY(0); height: auto; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="{{ asset('images/logo-demande.jpg') }}" alt="Logo" style="width: 80px; height: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
            </div>
            <h2>Créer un Compte</h2>
            <p class="subtitle">Rejoignez la plateforme académique</p>

            {{-- Error Display --}}
            @if ($errors->any())
                <div class="notification error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Success Display --}}
            @if(session('success'))
                <div class="notification success" id="successMsg">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('compte.store') }}" method="POST" autocomplete="off" id="requestForm">
                @csrf
                
                <div class="form-group">
                    <label>Nom Complet</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nom_complet" value="{{ old('nom_complet') }}" placeholder="Ex: John Doe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Académique</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nom@etude.univ.ma" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mot de Passe</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Profil</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-badge"></i>
                        <select name="role">
                            <option value="ingenieur">Ingénieur</option>
                            <option value="enseignant">Enseignant</option>
                            <option value="doctorant">Doctorant</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Envoyer ma Demande <i class="fas fa-paper-plane" style="margin-left: 8px;"></i>
                </button>
            </form>

            <a href="{{ url('/espace-invite') }}" class="back-link">
                <i class="fas fa-arrow-left" style="margin-right: 5px;"></i> Retour au catalogue
            </a>
        </div>
    </div>

    <script>
        // Animations & Cleanup
        document.addEventListener('DOMContentLoaded', () => {
            // Check for success message to clear form
            @if(session('success'))
                const form = document.getElementById('requestForm');
                if(form) form.reset();
                
                // Clear all individual inputs just in case browser autofilled
                document.querySelectorAll('input').forEach(input => input.value = '');
                document.querySelector('select').selectedIndex = 0;

                // Auto-hide success message after 5 seconds
                /*
                setTimeout(() => {
                    const msg = document.getElementById('successMsg');
                    if(msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateY(-10px)';
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 5000);
                */
            @endif

            // Add simple interaction effects
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                   input.parentElement.querySelector('i').style.color = 'var(--accent)';
                });
                input.addEventListener('blur', () => {
                   if(input.value.length === 0) {
                       input.parentElement.querySelector('i').style.color = 'var(--text-secondary)';
                   }
                });
            });
        });
    </script>
</body>
</html>
