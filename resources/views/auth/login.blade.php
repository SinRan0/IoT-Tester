<div class="card">
    <h2>🔐 Login</h2>

    <form method="POST" action="{{ route('auto.login') }}">
        @csrf
        <button type="submit">Masuk ke Dashboard 🚀</button>
    </form>
</div>
