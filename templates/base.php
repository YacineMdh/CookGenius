<!-- base.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Finder</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a CSS file -->
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/recette/search">Recette Search</a></li>
        </ul>
    </nav>

    <!-- Main content will be injected here -->
    <div class="content">
        <?php echo $content; ?> <!-- Dynamic content placeholder -->
    </div>

    <!-- Footer (Optional) -->
    <footer>
        <p>&copy; 2025 Recipe Finder. All rights reserved.</p>
    </footer>

</body>
</html>
