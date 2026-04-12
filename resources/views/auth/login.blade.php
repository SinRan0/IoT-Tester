<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login IoT</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 320px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #4facfe;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

.error {
    color: red;
    font-size: 14px;
}
</style>
</head>

<body>

<div class="card">
    <h2>🔐 Login</h2>

    <!-- ERROR GLOBAL -->
    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p style="text-align:center;">
        Belum punya akun? <a href="{{ route('register') }}">Register</a>
    </p>
</div>

</body>
</html>
