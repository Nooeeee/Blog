<?php
    require_once("init.php");
?>
<html lang="fr">
    <body>
        <header>
            <ul>
                <li><a href="connexion.php">Inscription/Connexion</a></li>
            </ul>
            <?php if ( isConnected() ) { ?>
                <form method="POST">
                    <button type="submit" name="logout">Déconnexion</button>
                </form>
            <?php } ?>


        </header>

