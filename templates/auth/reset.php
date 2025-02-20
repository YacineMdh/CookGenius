<div class="container">
    <form method="POST" action="/reset-password/<?=$token?>">
        <h2>Réinitialisation du mot de passe</h2>
        <div>
            <p>noveau mot de passe</p>
            <input type="password" name="password"/>
        </div>
        <button type="submit">Réinitialiser</button>
    </form>