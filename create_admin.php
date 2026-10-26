<?php
/* Insertion du compte admin dans la Base de données.
 * Aller sur la page suivante : http://localhost/TP_Blog/create_admin.php
 * 'TP_Blog' est à remplacer par le dossier où le projet est enregistré
 */
    require_once("init.php");

    $connexion = getConnexion();
    $stmt = $connexion->query("SELECT * FROM user WHERE email='admin@localhost.fr'");

    if ( $stmt && $stmt->fetch() === false ) {
        $connexion->query("INSERT INTO user (email, mdp, pseudo, admin) VALUES('admin@localhost.fr', 'admin69IUT;', 'admin', 1)");
        echo "Administrateur créé avec succès.";
    } else {
        echo "Administrateur déjà existant.";
    }
?>