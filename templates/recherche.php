<?php
require_once __DIR__ . '/../src/config.php';
?>

<div class="search-container">
    <h1><?= $lang['search']; ?></h1>

    <form action="?page=recherche" method="POST" class="search-form">
        <div class="form-group">
            <label for="ingredients"> <?= $lang['available_ingredients']; ?> </label>
            <input type="text"
                   name="ingredients"
                   id="ingredients"
                   placeholder="<?= $lang['ingredients_placeholder']; ?>"
                   required>
            <small><?= $lang['separate_ingredients']; ?></small>
        </div>

        <div class="form-group">
            <label for="exclude"> <?= $lang['exclude_ingredients']; ?> </label>
            <input type="text"
                   name="exclude"
                   id="exclude"
                   placeholder="<?= $lang['exclude_placeholder']; ?>">
            <small><?= $lang['separate_ingredients']; ?></small>
        </div>

        <button type="submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <?= $lang['search']; ?>
        </button>
    </form>

    <?php if (isset($recettes)): ?>
        <div class="results-section">
            <h2><?= $lang['found_recipes']; ?></h2>
            <div class="recipes-grid">
                <?php foreach ($recettes as $recette): ?>
                    <article class="recipe-card">
                        <div class="recipe-image">
                            <img src="<?= htmlspecialchars($recette['image']) ?>"
                                 alt="<?= htmlspecialchars($recette['title']) ?>">
                        </div>
                        <div class="recipe-content">
                            <h3><?= htmlspecialchars($recette['title']) ?></h3>
                            <a href="/recette/detail/<?= $recette['id'] ?>" class="view-recipe">
                                <?= $lang['view_recipe']; ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    h1 {
        font-size: 2rem;
        color: #2d3748;
        margin-bottom: 2rem;
        text-align: center;
    }

    .search-form {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    small {
        display: block;
        color: #718096;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    input[type="text"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input[type="text"]:focus {
        outline: none;
        border-color: #4299e1;
    }

    button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #2F855A;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button:hover {
        background: #276749;
    }

    .results-section {
        margin-top: 3rem;
    }

    .results-section h2 {
        color: #2d3748;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .recipes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .recipe-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
    }

    .recipe-card:hover {
        transform: translateY(-4px);
    }

    .recipe-image {
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .recipe-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recipe-content {
        padding: 1.5rem;
    }

    .recipe-content h3 {
        color: #2d3748;
        margin: 0 0 1rem 0;
        font-size: 1.25rem;
    }

    .view-recipe {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #4299e1;
        text-decoration: none;
        font-weight: 600;
    }

    .view-recipe:hover {
        color: #3182ce;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .search-container {
            padding: 1rem;
        }

        .recipes-grid {
            grid-template-columns: 1fr;
        }

        .search-form {
            padding: 1.5rem;
        }
    }
</style>