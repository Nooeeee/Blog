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

    function getUserByEmail(?string $email){
        $stmt = getConnexion()->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    function getAllEmail($connexion) {
        $stmt = $connexion->query("SELECT email FROM user");
        return $stmt->fetchAll();
    }

    function createUser(string $email, string $pwd, string $pseudo, bool $admin = false): int {
        $st = getConnexion()->prepare("INSERT INTO User (email, mdp, pseudo, admin) VALUES(?, ?, ?, ?)");
        $st->execute( [$email, $pwd, $pseudo, (int) $admin] );
        return (int) getConnexion()->lastInsertId();
    }

?>
