<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'Ouverture de Compte | DataCenter</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Shared variables from style.css for consistency */
        :root {
            --bg-app: #090a0d;
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --accent: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.5);
            --border: rgba(255, 255, 255, 0.08); /* Dark mode delicate border */
            --radius-lg: 30px;
            --font-main: 'Inter', sans-serif;
            --font-heading: 'Instrument Sans', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: var(--font-main); }

        body {
            /* Fallback */
            background-color: #0f172a;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* 
         * Background Image Implementation 
         * Using the new user-provided isometric server image with blur.
         */
        body::before {
            content: '';
            position: fixed; /* Fixed to cover screen even during scroll (if any) */
            top: -10px; left: -10px; right: -10px; bottom: -10px; /* Slight bleed to avoid edge blur issues */
            background-image: url("{{ asset('images/bg-account-request.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            
            /* The requested blur effect */
            filter: blur(6px) brightness(0.6); 
            z-index: -1;
        }

        .main-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        /* ... existing styles ... */

        /* Dark Glass Card to match Welcome Page */
        .card {
            background: rgba(18, 20, 26, 0.7); /* Dark translucent */
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        /* Top shine gradient */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 20px;
            /* In dark mode, logos might need a small white bg or glow if transparent */
            /* filter: drop-shadow(0 0 15px rgba(255,255,255,0.1)); */
        }

        .page-title {
            font-family: var(--font-heading);
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Dark Inputs */
        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.03); /* Subtle dark fill */
            border: 1px solid var(--border);
            border-radius: 12px;
            transition: 0.2s;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
        }
        
        select.form-input option {
            background-color: #12141a; /* Dark dropdown bg */
            color: white;
        }

        /* Gradient Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--accent); /* Fallback */
            background: linear-gradient(135deg, var(--accent) 0%, #2563eb 100%);
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: var(--text-secondary);
            font-size: 14px;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--text-primary);
        }

        /* Alerts */
        .alert {
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</head>
<body>

    <div class="main-container">
        
        <div class="card">
            
            <div class="brand-header">
                <img src="{{ asset('images/logo-demande.jpg') }}" alt="Logo" class="brand-logo">
                <h1 class="page-title">Bienvenue</h1>
                <p class="page-subtitle">Remplissez le formulaire pour demander votre compte.</p>
            </div>

            {{-- Error Feedback --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle" style="margin-top: 2px;"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Success Feedback --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-top: 2px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('compte.store') }}" method="POST" autocomplete="off">
                @csrf
                
                <div class="form-group">
                    <label class="label">Nom Complet</label>
                    <input type="text" name="nom_complet" class="form-input" 
                           value="{{ old('nom_complet') }}" 
                           placeholder="Ex: Alami Jalal" required>
                </div>

                <div class="form-group">
                    <label class="label">Email Académique</label>
                    <input type="email" name="email" class="form-input" 
                           value="{{ old('email') }}" 
                           placeholder="prenom.nom@um5.ac.ma" required>
                </div>

                <div class="form-group">
                    <label class="label">Mot de Passe</label>
                    <input type="password" name="password" class="form-input" 
                           placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="label">Profil</label>
                    <div style="position: relative;">
                        <select name="role" class="form-input">
                            <option value="enseignant">Enseignant</option>
                            <option value="ingenieur">Ingénieur</option>
                            <option value="doctorant">Doctorant</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Envoyer ma demande <i class="fas fa-arrow-right"></i>
                </button>

            </form>
        </div>

        <a href="{{ url('/espace-invite') }}" class="back-link">
            ← Retour au catalogue
        </a>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- 1. Staggered Entrance Animation ---
            const elementsToAnimate = [
                '.brand-logo', 
                '.page-title', 
                '.page-subtitle', 
                '.form-group', 
                '.btn-submit',
                '.back-link'
            ];

            // Flatten logic to get all elements in order
            let delay = 100; // ms
            const allElements = [];

            elementsToAnimate.forEach(selector => {
                const els = document.querySelectorAll(selector);
                els.forEach(el => allElements.push(el));
            });

            // Set initial state via JS to allow graceful degradation if JS fails
            allElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
            });

            // Trigger animations
            setTimeout(() => {
                allElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }, 100);


            // --- 2. Subtle 3D Tilt Effect on Card ---
            const card = document.querySelector('.card');
            const container = document.querySelector('.main-container');

            if (card && container && window.innerWidth > 768) {
                container.addEventListener('mousemove', (e) => {
                    const rect = container.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    // Calculate center
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    // Angle values (max rotation)
                    const rotateX = ((y - centerY) / centerY) * -4; // Max -4deg to 4deg
                    const rotateY = ((x - centerX) / centerX) * 4;

                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });

                // Reset on mouse leave
                container.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
                    card.style.transition = 'transform 0.5s ease-out'; // Smooth return
                });

                container.addEventListener('mouseenter', () => {
                   card.style.transition = 'transform 0.1s ease-out'; // Quick response on enter
                });
            }

            // --- 3. Button Ripple Effect (Optional but "Oion" friendly) ---
            const btn = document.querySelector('.btn-submit');
            if(btn) {
                btn.addEventListener('click', function(e) {
                    let ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    let x = e.clientX - e.target.offsetLeft;
                    let y = e.clientY - e.target.offsetTop;
                    
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            }
        });
    </script>
    
    <style>
        /* Extra styles for JS effects */
        .btn-submit {
            position: relative;
            overflow: hidden; /* For ripple */
        }
        
        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            width: 100px;
            height: 100px;
            pointer-events: none;
            margin-left: -50px;
            margin-top: -50px;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
