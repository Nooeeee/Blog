<?php
    require_once __DIR__ . '/../config/init.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TPBlog/style/style.css">
    <title>Mon Blog</title>
</head>
    <body>
        <header>
            <?php if ( !isConnected() ): ?>
                <a href="/TPBlog/connexion.php" class="nav-link">Inscription/Connexion</a>
            <?php endif; ?>

            <?php if ( isConnected() ): ?>
                <nav class="nav-menu">
                    <a href="/TPBlog/index.php" class="nav-link">Accueil</a>
                    <a href="/TPBlog/create_article.php" class="nav-link">Créer un article</a>

                    <?php if ( isAdmin() ): ?>
                        <a href="/TPBlog/admin/index.php" class="nav-link nav-admin">Gérer catégorie(s)</a>
                    <?php endif; ?>
                </nav>

                <form method="POST" class="form-logout">
                    <button type="submit" name="logout" class="btn-logout">Déconnexion</button>
                </form>
            <?php endif; ?>
        </header>
