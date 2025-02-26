<style>
    .recipe-list {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: stretch; 

    .recipe {
        border: 1px solid #f8f9fa;
        border-radius: 4px;
        padding: 1rem;
        width: 200px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        min-height: 320px; 
    }

    .recipe img {
        width: 100%;
        border-radius: 4px;
    }

    .recipe h3 {
        flex-grow: 1;
        margin: 0.5rem 0;
    }

    .recipe a {
        display: block;
        text-align: center;
        background-color: #A67C52;
        color: white;
        padding: 0.5rem;
        border-radius: 4px;
        text-decoration: none;
        margin-top: auto; 
    }

    .recipe a:hover {
        background-color: #5C3B1E;
    }
</style>

<?php
require_once __DIR__ . '/../src/config.php';
?>

<h1><?= $lang['welcome']; ?></h1>

<section>
    <h2><?= $lang['random']; ?></h2>
    <div class="recipe-list">
        <?php foreach ($randomRecipes as $recipe): ?>
            <div class="recipe">
                <img src="<?= htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="/recette/detail/<?= urlencode($recipe['id']); ?>"><?= $lang['details']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section>
    <h2><?= $lang ['most_common']; ?></h2>
    <div class="recipe-list">
        <?php foreach ($commonRecipes as $recipe): ?>
            <div class="recipe">
                <img src="<?= htmlspecialchars($recipe['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>">
                <h3><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <a href="/recette/detail/<?= urlencode($recipe['id']); ?>"><?= $lang['details']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</section>