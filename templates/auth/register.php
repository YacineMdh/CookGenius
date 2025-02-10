<div class="container">
    <form method="POST" action="/register">
        <h2>Inscription</h2>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Mot de passe:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Confirmer le mot de passe:</label>
            <input type="password" name="password_confirm" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
</div>