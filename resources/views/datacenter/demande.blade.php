<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande d'ouverture de compte</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .form-card { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; text-align: center; }
        .field { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        .btn-submit:hover { background: #219150; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
        .error-list { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>Demande d'Ouverture de Compte</h2>

        {{-- Affichage des erreurs de validation (ex: email déjà pris) --}}
        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('compte.store') }}" method="POST">
            @csrf
            <div class="field">
                <label>Nom complet</label>
                <input type="text" name="nom_complet" value="{{ old('name') }}" required>
            </div>
            <div class="field">
                <label>Email académique/professionnel</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <div class="field">
                <label>Vous êtes :</label>
                <select name="role">
                    <option value="ingenieur">Ingénieur</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="doctorant">Doctorant</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Envoyer ma demande</button>
        </form>
@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
        {{-- Correction du lien vers la route correcte : /espace-invite --}}
        <a href="{{ url('/espace-invite') }}" class="back-link">← Retour au catalogue</a>
    </div>
</body>
</html>
