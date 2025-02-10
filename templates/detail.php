<!-- detail.php -->
<h1>Recipe Details</h1>

<?php if (!empty($recetteDetails)): ?>
    <h2><?= htmlspecialchars($recetteDetails['title']); ?></h2>
    <img src="<?= htmlspecialchars($recetteDetails['image']); ?>" alt="<?= htmlspecialchars($recetteDetails['title']); ?>">
    <p><strong>Instructions:</strong></p>
    <p><?= htmlspecialchars($recetteDetails['instructions']); ?></p>
    <!-- Add more details if necessary -->
<?php else: ?>
    <p>Recipe details not available.</p>
<?php endif; ?>
