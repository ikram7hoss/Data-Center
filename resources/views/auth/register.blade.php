<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f6f7fb; color: #111; margin: 0;">
    <main style="max-width: 520px; margin: 48px auto; background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
        <h1 style="margin: 0 0 16px; font-size: 22px;">Créer un compte</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label style="display: block; margin: 12px 0 6px;">Nom</label>
            <input name="name" type="text" required value="{{ old('name') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Email</label>
            <input name="email" type="email" required value="{{ old('email') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Mot de passe</label>
            <input name="password" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Confirmer le mot de passe</label>
            <input name="password_confirmation" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <button type="submit" style="margin-top: 16px; background: #0f766e; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; cursor: pointer;">
                S'inscrire
            </button>
        </form>
    </main>
</body>
</html>
