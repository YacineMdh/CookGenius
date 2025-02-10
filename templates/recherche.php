<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Recettes</title>
</head>
<body>
    <h1>Rechercher une recette</h1>
    <form action="?page=recherche" method="POST">
        <label>Ingrédients disponibles (séparés par des virgules) :</label><br>
        <input type="text" name="ingredients" id="ingredients" placeholder="ex : eggs, flour, sugar" required><br><br>
        <br><br>

        <label>Ingrédients à exclure (séparés par des virgules) :</label><br>
        <input type="text" name="exclude"><br><br>

        <button type="submit">Rechercher</button>
    </form>

    <?php if (isset($recettes)): ?>
        <h2>Résultats :</h2>
        <ul>
            <?php foreach ($recettes as $recette): ?>
                <li>
                    <strong><?= htmlspecialchars($recette['title']) ?></strong><br>
                    <img src="<?= htmlspecialchars($recette['image']) ?>" alt="<?= htmlspecialchars($recette['title']) ?>" width="150"><br>
                    <p><?= $recette['id'] ?></p>
                    <a href="/recette/detail/<?= $recette['id'] ?>">Voir la recette</a>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
