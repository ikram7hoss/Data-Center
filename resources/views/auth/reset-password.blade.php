<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f6f7fb; color: #111; margin: 0;">
    <main style="max-width: 520px; margin: 48px auto; background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
        <h1 style="margin: 0 0 12px; font-size: 22px;">Nouveau mot de passe</h1>
        <form method="POST" action="{{ url('/reset-password') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label style="display: block; margin: 12px 0 6px;">Email</label>
            <input name="email" type="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Nouveau mot de passe</label>
            <input name="password" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Confirmer le mot de passe</label>
            <input name="password_confirmation" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <button type="submit" style="margin-top: 16px; background: #0f766e; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; cursor: pointer;">
                Mettre à jour
            </button>
        </form>
    </main>
</body>
</html>
