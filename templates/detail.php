<h1>Recipe Details</h1>

<?php if (!empty($recetteDetails)): ?>
    <h2><?= htmlspecialchars($recetteDetails['title']); ?></h2>
    <img src="<?= htmlspecialchars($recetteDetails['image']); ?>" alt="<?= htmlspecialchars($recetteDetails['title']); ?>">

    
    <p><strong>Cooking Time:</strong> <?= htmlspecialchars($recetteDetails['readyInMinutes']); ?> minutes</p>
    <p><strong>Servings:</strong> <?= htmlspecialchars($recetteDetails['servings']); ?></p>
   

    <h3>Ingredients:</h3>
    <ul>
        <?php foreach ($recetteDetails['extendedIngredients'] as $ingredient): ?>
            <li><?= htmlspecialchars($ingredient['original']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Health Information:</h3>
    <ul>
        <li><strong>Vegetarian:</strong> <?= $recetteDetails['vegetarian'] ? 'Yes' : 'No'; ?></li>
        <li><strong>Vegan:</strong> <?= $recetteDetails['vegan'] ? 'Yes' : 'No'; ?></li>
        <li><strong>Gluten-Free:</strong> <?= $recetteDetails['glutenFree'] ? 'Yes' : 'No'; ?></li>
        <li><strong>Dairy-Free:</strong> <?= $recetteDetails['dairyFree'] ? 'Yes' : 'No'; ?></li>
    </ul>

    <h3>Summary:</h3>
    <p><?= htmlspecialchars($recetteDetails['summary']); ?></p>

    <p><strong>Source:</strong> <a href="<?= htmlspecialchars($recetteDetails['sourceUrl']); ?>" target="_blank">View Recipe Source</a></p>
   
    <p>Recipe details not available.</p>
<?php endif; ?>
