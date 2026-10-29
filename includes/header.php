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
            <ul>
                <li><a href="/TPBlog/connexion.php">Inscription/Connexion</a></li>
            </ul>
            <?php if ( isConnected() ) { ?>
                <a href="/TPBlog/create_article.php">Créer un article</a>
                <br/><br/>

                <form method="POST">
                    <button type="submit" name="logout">Déconnexion</button>
                </form>

            <?php } ?>


        </header>

