<?php
    function getConnexion(): PDO {
        static $connexion = null; // singleton

        if ($connexion === null) {
            try {
                $connexion = new PDO('mysql:host=localhost;dbname=TP_blog', 'root', '');
            } catch (Exception $e) {
                die("Erreur connexion à la base de données" . $e->getMessage());
            }
        }

        return $connexion;
    }

    function getAllEmail($connexion) {
        $stmt = $connexion->query("SELECT email FROM utilisateur");
        $rows = $stmt->fetchAll();
        return $rows;
    }

    function saveUser($connexion) {
        $sql = "INSERT INTO utilisateur (email, mdp) VALUES(?, ?)";
        $st = $connexion->prepare($sql);

        $mdpChiffre = password_hash($_SESSION['mdp'], PASSWORD_DEFAULT);

        $st->bindParam(1, $_SESSION['email']);
        $st->bindParam(2, $mdpChiffre);

        $st->execute();
    }

?>
