<style>
    .health-container {
    }

    h1 {
        font-size: 2rem;
        color: #5C3B1E;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .health-form {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        font-weight: 700;
        color: #5C3B1E;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    input[type="number"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        background: #fff5e1;
        color: #5C3B1E;
        font-weight: bold;
    }

    button {
        background: #2F855A;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background: #276749;
    }

    .results-section {
        margin-top: 2rem;
        padding: 1.5rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .results-section h2 {
        text-align: center;
        color: #5C3B1E;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .results-section p {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
        color: #2d3748;
    }

    .meals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .meal-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
    }

    .meal-content h3 {
        margin: 0 0 0.5rem 0;
        color: #5C3B1E;
        font-size: 1.2rem;
    }

    .recipe-image img {
        width: 100%;
        border-radius: 8px;
    }

    .view-recipe {
        margin-top: auto;
        display: block;
        text-align: center;
        background-color: #A67C52;
        color: white;
        padding: 0.75rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease-in-out;
    }

    .view-recipe:hover {
        background-color: #5C3B1E;
    }
</style>

<?php
require_once __DIR__ . '/../src/config.php';
?>

<div class="health-container">
    <h1><?= $lang['health']; ?></h1>

    <form action="?page=health" method="POST" class="health-form">
        <div class="form-group">
            <label for="calories"> <?= $lang['calories']; ?> </label>
            <input type="number" name="calories" id="calories" placeholder="<?= $lang['calories_placeholder']; ?>" required>
        </div>

        <div class="form-group">
            <label for="meals"> <?= $lang['meals']; ?> </label>
            <input type="number" name="meals" id="meals" placeholder="<?= $lang['meals_placeholder']; ?>" required>
        </div>

        <button type="submit"> <?= $lang['generate_plan']; ?> </button>
    </form>

    <?php if (isset($suggestions) && isset($calories)): ?>
        <div class="results-section">
            <h2><?= $lang['meal_suggestions']; ?></h2>

            <p><strong><?= $lang['total_calories']; ?> :</strong> <?= htmlspecialchars($calories) ?> kcal</p>
            <div class="meals-grid">
                <?php foreach ($suggestions as $meal): ?>
                    <article class="meal-card">
                        <div class="meal-content">
                            <h3><?= htmlspecialchars($meal['title']) ?></h3>
                            <div class="recipe-image">
                                <img src="<?= htmlspecialchars($meal['image']) ?>"
                                    alt="<?= htmlspecialchars($meal['title']) ?>">
                            </div>
                            <p><strong><?= $lang['calories']; ?> :</strong> <?= isset($meal['nutrition']["nutrients"][0]["amount"]) ? htmlspecialchars($meal['nutrition']["nutrients"][0]["amount"]) : 'N/A' ?></p>
                        </div>
                        <a href="/recette/detail/<?= $meal['id'] ?>" class="view-recipe">
                            <?= $lang['view_recipe']; ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>