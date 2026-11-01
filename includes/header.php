<?php
    require_once __DIR__ . '/../config/init.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
</head>
    <body>
        <header>
            <a href="/TPBlog/connexion.php">Inscription/Connexion</a>
            <br/>
            <?php if ( isConnected() ): ?>
                <a href="/TPBlog/index.php">Accueil</a>
                <br/>
                <a href="/TPBlog/create_article.php">Créer un article</a>
                <br/><br/>

                <form method="POST">
                    <button type="submit" name="logout">Déconnexion</button>
                </form>
            <?php endif; ?>


        </header>

