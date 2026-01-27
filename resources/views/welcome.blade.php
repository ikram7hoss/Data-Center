<div class="container">
    <div style="margin-bottom: 20px; text-align: center;">
        <a href="{{ route('demande.create') }}" style="color: red; font-weight: bold; font-size: 20px;">
            ➜ ACCÉDER AU FORMULAIRE DE DEMANDE
        </a>
    </div>

    @if (Route::has('login'))
        <div class="auth-links" style="text-align: right;">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" style="margin-left: 10px;">S'enregistrer</a>
                @endif
            @endauth
        </div>
    @endif
</div>
