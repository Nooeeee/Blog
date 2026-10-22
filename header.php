<?php
    declare(strict_types=1);
    session_start();

    ini_set(option:'display_errors', value: 1);
    ini_set(option:'display_startup_errors', value: 1);
    error_reporting(error_level: E_ALL);

    require_once("utils.php");
    require_once("pdo.php");
?>
<html lang="fr">
    <body>
        <header>
            <ul>
                <li><a href="index.php">Accueil</a></li>
            </ul>
        </header>

