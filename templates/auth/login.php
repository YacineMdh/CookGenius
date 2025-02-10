<div class="container">
    <form method="POST" action="/login">
        <h2>Connexion</h2>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Mot de passe:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
        <a href="/forgot-password">Mot de passe oublié?</a>
        <a href="/register">S'inscrire</a>
    </form>
</div>