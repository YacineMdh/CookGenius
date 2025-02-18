<?php
use App\Service\RatingService;
use App\Service\FavoriteService;

$ratingService = new RatingService();
$favoriteService = new FavoriteService();

$recipe_id = $recetteDetails['id'] ?? 0;
$ratings = $ratingService->getRecipeRatings($recipe_id);
$stats = $ratingService->getAverageRating($recipe_id);

$isFavorite = isset($_SESSION['user_id']) ? $favoriteService->isFavorite($_SESSION['user_id'], $recipe_id) : false;

$ratingStats = [
    'average' => $stats['average'] ?? 0,
    'total' => $stats['total'] ?? 0,
    '5_stars' => $stats['five_stars'] ?? 0,
    '4_stars' => $stats['four_stars'] ?? 0,
    '3_stars' => $stats['three_stars'] ?? 0,
    '2_stars' => $stats['two_stars'] ?? 0,
    '1_stars' => $stats['one_star'] ?? 0
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recetteDetails['title'] ?? 'Recipe Details') ?> - Recipe Finder</title>
    <style>
        :root {
            --primary-color: #4299e1;
            --accent-color: #48bb78;
            --danger-color: #f56565;
            --text-color: #2d3748;
            --bg-color: #f7fafc;
            --card-bg: #ffffff;
            --nav-height: 4rem;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            color: var(--text-color);
            background-color: var(--bg-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .recipe-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .recipe-title-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .recipe-title-wrapper h1 {
            font-size: 2.5rem;
            color: var(--text-color);
            margin: 0;
        }

        .recipe-image {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .recipe-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .recipe-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .meta-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .meta-card .label {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .meta-card .value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .recipe-section {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .recipe-section h2 {
            font-size: 1.5rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .ingredients-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .ingredients-list li {
            padding: 0.75rem;
            background: var(--bg-color);
            border-radius: 0.5rem;
        }

        .dietary-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .diet-tag {
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            background: var(--bg-color);
            color: #666;
        }

        .diet-tag.active {
            background: var(--accent-color);
            color: white;
        }

        .recipe-summary {
            line-height: 1.8;
            color: #4a5568;
        }

        /* Système de notation */
        .ratings-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .rating-overview {
            text-align: center;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .average-rating {
            font-size: 3rem;
            font-weight: bold;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }

        .rating-bars {
            flex: 1;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .bar-wrapper {
            flex: 1;
            height: 8px;
            background: var(--bg-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .bar {
            height: 100%;
            background: var(--primary-color);
            border-radius: 4px;
        }

        .favorite-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--danger-color);
            background: white;
            border-radius: 2rem;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .favorite-btn:hover,
        .favorite-btn.is-favorite {
            background: var(--danger-color);
            color: white;
        }

        .star-rating {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin: 1rem 0;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 2rem;
            color: #e2e8f0;
            transition: color 0.2s;
        }

        .star-rating label:hover,
        .star-rating input:checked ~ label {
            color: #fbbf24;
        }

        .review-form textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin: 1rem 0;
            font-family: inherit;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #3182ce;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .recipe-title-wrapper {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .recipe-title-wrapper h1 {
                font-size: 2rem;
            }

            .ratings-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <article class="recipe-detail">
        <header class="recipe-header">
            <div class="recipe-title-wrapper">
                <h1><?= htmlspecialchars($recetteDetails['title']) ?></h1>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="/recipe/toggle-favorite" method="POST">
                        <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">
                        <button type="submit" class="favorite-btn <?= $isFavorite ? 'is-favorite' : '' ?>">
                            <?= $isFavorite ? '❤️ Saved' : '🤍 Save' ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if (!empty($recetteDetails['image'])): ?>
                <div class="recipe-image">
                    <img src="<?= htmlspecialchars($recetteDetails['image']) ?>"
                         alt="<?= htmlspecialchars($recetteDetails['title']) ?>">
                </div>
            <?php endif; ?>
        </header>

        <div class="recipe-meta">
            <div class="meta-card">
                <div class="label">⏱️ Cooking Time</div>
                <div class="value"><?= $recetteDetails['readyInMinutes'] ?? 0 ?> min</div>
            </div>
            <div class="meta-card">
                <div class="label">👥 Servings</div>
                <div class="value"><?= $recetteDetails['servings'] ?? 0 ?></div>
            </div>
        </div>

        <?php if (!empty($recetteDetails['extendedIngredients'])): ?>
            <section class="recipe-section">
                <h2>Ingredients</h2>
                <ul class="ingredients-list">
                    <?php foreach ($recetteDetails['extendedIngredients'] as $ingredient): ?>
                        <li><?= htmlspecialchars($ingredient['original']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="recipe-section">
            <h2>Dietary Information</h2>
            <div class="dietary-tags">
                    <span class="diet-tag <?= ($recetteDetails['vegetarian'] ?? false) ? 'active' : '' ?>">
                        Vegetarian
                    </span>
                <span class="diet-tag <?= ($recetteDetails['vegan'] ?? false) ? 'active' : '' ?>">
                        Vegan
                    </span>
                <span class="diet-tag <?= ($recetteDetails['glutenFree'] ?? false) ? 'active' : '' ?>">
                        Gluten-Free
                    </span>
                <span class="diet-tag <?= ($recetteDetails['dairyFree'] ?? false) ? 'active' : '' ?>">
                        Dairy-Free
                    </span>
            </div>
        </section>

        <?php if (!empty($recetteDetails['summary'])): ?>
            <section class="recipe-section">
                <h2>About this Recipe</h2>
                <div class="recipe-summary">
                    <?= $recetteDetails['summary'] ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="recipe-section">
            <h2>Ratings & Reviews</h2>
            <div class="ratings-wrapper">
                <div class="rating-overview">
                    <div class="average-rating">
                        <?= number_format($ratingStats['average'], 1) ?>
                        <span class="max">/5</span>
                    </div>
                    <div class="total-ratings">
                        Based on <?= $ratingStats['total'] ?> reviews
                    </div>
                </div>

                <div class="rating-bars">
                    <?php for ($i = 5; $i >= 1; $i--):
                        $count = $ratingStats["{$i}_stars"];
                        $percentage = $ratingStats['total'] > 0 ? ($count / $ratingStats['total'] * 100) : 0;
                        ?>
                        <div class="rating-bar">
                            <span><?= $i ?> stars</span>
                            <div class="bar-wrapper">
                                <div class="bar" style="width: <?= $percentage ?>%"></div>
                            </div>
                            <span><?= $count ?></span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div id="comments">
                <?php if (!empty($ratings)): ?>
                    <?php foreach ($ratings as $rating): ?>
                        <div class="review">
                            <div class="review-header">
                                <div class="review-author">
                                    <?= htmlspecialchars($rating['firstname'] . ' ' . $rating['lastname']) ?>
                                </div>
                                <div class="review-date">
                                    <?= date('M d, Y', strtotime($rating['created_at'])) ?>
                                </div>
                            </div>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= $rating['rating'] ? 'active' : '' ?>">⭐</span>
                                <?php endfor; ?>
                            </div>
                            <div class="review-comment">
                                <?= htmlspecialchars($rating['comment']) ?>
                            </div>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $rating['user_id']): ?>
                                <form action="/recipe/delete-rating" method="POST">
                                    <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">
                                    <input type="hidden" name="rating_id" value="<?= $rating['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete Review</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet. Be the first to review this recipe!</p>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="review-form">
                    <h3>Add Your Review</h3>
                    <form action="/recipe/rate" method="POST">
                        <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">

                        <div class="star-rating">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
                                <label for="star<?= $i ?>">⭐</label>
                            <?php endfor; ?>
                        </div>

                        <textarea name="comment"
                                  placeholder="Share your thoughts about this recipe..."
                                  required></textarea>

                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                </div>
            <?php endif; ?>
        </section>

        <?php if (!empty($recetteDetails['sourceUrl'])): ?>
        <footer class="recipe-footer">
            <a href="<?= htmlspecialchars($recetteDetails['sourceUrl']) ?>" class="btn btn-primary" target="_blank">View Full Recipe</a>
        </footer>
        <?php endif; ?>
    </article>
</div>
</body>
</html>
