<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f6f7fb; color: #111; margin: 0;">
    <main style="max-width: 720px; margin: 48px auto; background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
        <h1 style="margin: 0 0 16px; font-size: 22px;">Mon profil</h1>

        <form method="POST" action="{{ url('/profile') }}">
            @csrf
            @method('PATCH')
            <label style="display: block; margin: 12px 0 6px;">Nom</label>
            <input name="name" type="text" required value="{{ old('name', $user->name) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Email</label>
            <input name="email" type="email" required value="{{ old('email', $user->email) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <button type="submit" style="margin-top: 16px; background: #0f766e; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; cursor: pointer;">
                Mettre à jour
            </button>
        </form>

        <hr style="margin: 24px 0; border: 0; border-top: 1px solid #eee;">

        <form method="POST" action="{{ url('/password') }}">
            @csrf
            @method('PUT')
            <label style="display: block; margin: 12px 0 6px;">Mot de passe actuel</label>
            <input name="current_password" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Nouveau mot de passe</label>
            <input name="password" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <label style="display: block; margin: 12px 0 6px;">Confirmer le mot de passe</label>
            <input name="password_confirmation" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">

            <button type="submit" style="margin-top: 16px; background: #0f766e; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; cursor: pointer;">
                Changer le mot de passe
            </button>
        </form>

        <hr style="margin: 24px 0; border: 0; border-top: 1px solid #eee;">

        <form method="POST" action="{{ url('/profile') }}">
            @csrf
            @method('DELETE')
            <label style="display: block; margin: 12px 0 6px;">Confirmez avec votre mot de passe</label>
            <input name="password" type="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            <button type="submit" style="margin-top: 16px; background: #b91c1c; color: #fff; border: 0; padding: 10px 16px; border-radius: 6px; cursor: pointer;">
                Supprimer le compte
            </button>
        </form>
    </main>
</body>
</html>
