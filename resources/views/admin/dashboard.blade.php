<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>
<body>
    <h1>Bienvenue sur le Dashboard Administrateur</h1>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

</body>
</html>
