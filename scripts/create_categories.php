<?php
/* Insertion des catégories dans la Base de données.
 * L'import de la base de données inclus les données insérées dans ce fichier.
 * Il n'est donc pas forcément utile de réaliser les instructions ci-dessous.
 * Aller sur la page suivante : http://localhost/TP_Blog/create_categories.php
 * 'TP_Blog' est à remplacer par le dossier où le projet est enregistré
 */
    require_once __DIR__ . '/../config/init.php';

    $categories = [
        'Développement Web',
        'Programmation Java',
        'Base de données',
        'Cybersécurité',
        'Intelligence Artificielle',
        'Systèmes & Réseaux'
    ];

    $connexion = getConnexion();

    $stmtCheck = $connexion->prepare("SELECT nom FROM Categorie WHERE nom=?");
    $stmtInsert = $connexion->prepare("INSERT INTO Categorie (nom) VALUES (?)");

    foreach ($categories as $categorie) {
        $stmtCheck->execute([$categorie]);

        if ( $stmtCheck->fetch() === false ) {
            $stmtInsert->execute([$categorie]);
            echo $categorie . " créé avec succès.<br/>";
        } else {
            echo $categorie . " existe déjà.<br/>";
        }
    }

?>