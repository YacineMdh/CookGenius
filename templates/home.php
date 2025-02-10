<!-- home.php -->
<h1>Welcome to the Recipe Finder</h1>

<section>
    <h2>🍽️ 5 Random Recipes</h2>
    <div class="recipe-list">
        <?php foreach ($randomRecipes as $recipe): ?>
            <div class="recipe">
                <img src="<?= htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="/recette/detail?id=<?= urlencode($recipe['id']); ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <h2>🔥 Most Common Recipes</h2>
    <div class="recipe-list">
        <?php foreach ($commonRecipes as $recipe): ?>
            <div class="recipe">
                <img src="<?= htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="/recette/detail?id=<?= urlencode($recipe['id']); ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
