<!-- home.php -->
<h1>Welcome to the Recipe Finder</h1>

<section>
    <h2>🍽️ 5 Random Recipes</h2>
    <div class="recipe-list">
        <?php foreach ($randomRecipes as $recipe): ?>
            <div class="recipe">
                <img src="<?= htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="/recette/detail/<?= urlencode($recipe['id']); ?>">View Details</a>
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
                <a href="/recette/detail/<?= urlencode($recipe['id']); ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
    .recipe-list {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .recipe {
        border: 1px solid #f8f9fa;
        border-radius: 4px;
        padding: 1rem;
        width: 200px;
    }

    .recipe img {
        width: 100%;
        border-radius: 4px;
    }

    .recipe h3 {
        margin: 0.5rem 0;
    }

    .recipe a {
        display: block;
        text-align: center;
        background-color: #007bff;
        color: white;
        padding: 0.5rem;
        border-radius: 4px;
        text-decoration: none;
    }

    .recipe a:hover {
        background-color: #0056b3;
    }
</style>