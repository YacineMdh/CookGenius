<div class="health-container">
    <h1>Plan Alimentaire Santé</h1>

    <form action="?page=health" method="POST" class="health-form">
        <div class="form-group">
            <label for="calories">Nombre de calories souhaité</label>
            <input type="number" name="calories" id="calories" placeholder="ex : 2000" required>
        </div>

        <div class="form-group">
            <label for="meals">Nombre de plats</label>
            <input type="number" name="meals" id="meals" placeholder="ex : 3" required>
        </div>

        <button type="submit">Générer le plan</button>
    </form>

    <?php if (isset($suggestions) &&  isset($calories)): ?>
        <div class="results-section">
            <h2>Suggestions de Plats</h2>

            <p><strong>Total Calories :</strong> <?= htmlspecialchars($calories) ?> kcal</p>
            <div class="meals-grid">
                <?php foreach ($suggestions as $meal): ?>
             
                    <article class="meal-card">
                        <div class="meal-content">
                            <h3><?= htmlspecialchars($meal['title']) ?></h3>
                                        <div class="recipe-image">
                                <img src="<?= htmlspecialchars($meal['image']) ?>"
                                    alt="<?= htmlspecialchars($meal['title']) ?>">
                            </div>
                            <p><strong>Calories :</strong> <?= isset($meal['nutrition']["nutrients"][0]["amount"]) ? htmlspecialchars($meal['nutrition']["nutrients"][0]["amount"]) : 'N/A' ?></p>
                        </div>
                        <a href="/recette/detail/<?= $meal['id'] ?>" class="view-recipe">
                                Voir la recette
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .health-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }

    h1 {
        font-size: 2rem;
        color: #2d3748;
        text-align: center;
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
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    input[type="number"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
    }

    button {
        background: #38a169;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
    }

    .results-section {
        margin-top: 2rem;
    }

    .meals-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .meal-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .meal-content h3 {
        margin: 0 0 0.5rem 0;
        color: #2d3748;
    }

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
        background: #4299e1;
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
        background: #3182ce;
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
