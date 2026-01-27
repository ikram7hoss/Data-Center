<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>LOGIN PAGE OK</h1>

    <form method="POST" action="/login">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="email" name="email">
        <input type="password" name="password">
        <button type="submit">Login</button>
    </form>
</body>
</html>
