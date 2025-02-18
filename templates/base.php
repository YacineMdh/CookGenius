<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/CookGeniusLogo.png">
    <title>Recipe Finder</title>
    <style>
        /* 🎨 Variables globales avec la nouvelle palette */
        :root {
            --primary-color: #A67C52; /* Marron clair */
            --accent-color: #D2691E; /* Orange doux */
            --bg-color: #F5E1DA; /* Beige */
            --text-color: #5C3B1E; /* Marron foncé */
            --white: #FFFFFF;
            --nav-height: 4rem;
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation */
        nav {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            height: var(--nav-height);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1.5rem; /* Espacement entre le logo et les liens */
        }

        .logo img {
            height: 80px;
            width: auto;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.2s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 500;
            color: var(--text-color);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .favorite-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
        }
        .remove-btn {
            background: var(--danger-color);
            color: white;
            border: 2px solid var(--danger-color);
        }

        .remove-btn:hover {
            background: #c53030; /* Rouge plus foncé au survol */
            border-color: #c53030;
        }

        .remove-btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(229, 62, 62, 0.6); /* Effet lumineux au focus */
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #3182ce;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #e53e3e;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Content */
        .content {
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Footer */
        footer {
            background: white;
            padding: 2rem 1rem;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
        }

        footer p {
            color: #718096;
            font-size: 0.875rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 0.5rem;
            }

            .nav-left {
                gap: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .user-info {
                flex-direction: column;
                gap: 0.5rem;
            }

            .content {
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .nav-link span {
                display: none;
            }

            .user-name {
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
<nav>
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="logo">
                <img src="/images/CookGeniusLogo.png" alt="CookGenius Logo">
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <ul class="nav-links">
                <li><a href="/" class="nav-link"><span>Home</span></a></li>
                <li><a href="/recette/recherche" class="nav-link"><span>Recherche</span></a></li>
                <li><a href="/favorite" class="nav-link"><span>Favoris</span></a></li>
                <li><a href="/health" class="nav-link"><span>Plan Santé</span></a></li>
            </ul>
            <?php endif; ?>
        </div>

        <div class="nav-right">
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-info">
                        <span class="user-name">
                            <?php
                            echo htmlspecialchars($_SESSION['user_firstname'] ?? '', ENT_QUOTES, 'UTF-8');
                            echo ' ';
                            echo htmlspecialchars($_SESSION['user_lastname'] ?? '', ENT_QUOTES, 'UTF-8');
                            ?>
                        </span>
                        <a href="/logout" class="btn btn-danger">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="auth-buttons">
                        <a href="/login" class="btn btn-outline">Connexion</a>
                        <a href="/register" class="btn btn-primary">Inscription</a>
                        
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="content">
    <?php echo $content; ?>
</div>

<footer>
    <p>&copy; 2025 Recipe Finder. All rights reserved.</p>
</footer>
</body>
</html>
