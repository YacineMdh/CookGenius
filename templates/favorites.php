
<div class="favorites-page">
    <h1>My Favorite Recipes</h1>

    <?php if (empty($favoriteRecipes)): ?>
        <div class="empty-state">
            <p>You haven't saved any recipes yet.</p>
            <a href="/" class="btn btn-primary">Discover Recipes</a>
        </div>
    <?php else: ?>
        <div class="recipe-grid">
            <?php foreach ($favoriteRecipes as $recipe): ?>
                <div class="recipe-card">
                    <img src="<?= htmlspecialchars($recipe['image']); ?>"
                         alt="<?= htmlspecialchars($recipe['title']); ?>"
                         class="recipe-image">

                    <div class="recipe-content">
                        <h2><?= htmlspecialchars($recipe['title']); ?></h2>

                        <div class="recipe-meta">
                            <span>⏱️ <?= $recipe['readyInMinutes']; ?> min</span>
                            <span>👥 <?= $recipe['servings']; ?> servings</span>
                        </div>

                        <div class="recipe-actions">
                            <a href="/recipe/<?= $recipe['id']; ?>" class="btn btn-primary">View Recipe</a>
                            <form action="/recipe/toggle-favorite" method="POST" class="favorite-form">
                                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                                <button type="submit" class="favorite-btn is-favorite">❤️ Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .favorites-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .favorites-page h1 {
        margin-bottom: 2rem;
        color: #333;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 0;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 1rem;
    }

    .recipe-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .recipe-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: white;
        transition: transform 0.2s;
    }

    .recipe-card:hover {
        transform: translateY(-4px);
    }

    .recipe-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .recipe-content {
        padding: 1rem;
    }

    .recipe-content h2 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .recipe-meta {
        display: flex;
        gap: 1rem;
        color: #666;
        margin-bottom: 1rem;
    }

    .recipe-actions {
        display: flex;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .favorites-page {
            padding: 1rem;
        }

        .recipe-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
    }
</style>