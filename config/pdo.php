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

    function getUserByEmail(string $email){
        $stmt = getConnexion()->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    function getPseudoById(int $idUser) : string {
        $stmt = getConnexion()->prepare("SELECT pseudo FROM user WHERE idUser=?");
        $stmt->execute([$idUser]);

        return $stmt->fetch();
    }

    function getIdByPseudo(string $pseudo) : int {
        $stmt = getConnexion()->prepare("SELECT idUser FROM user WHERE pseudo=?");
        $stmt->execute([$pseudo]);

        return $stmt->fetch();
    }

    function createUser(string $email, string $pwd, string $pseudo, bool $admin = false): int {
        $st = getConnexion()->prepare("INSERT INTO User (email, mdp, pseudo, admin) VALUES(?, ?, ?, ?)");
        $st->execute( [$email, $pwd, $pseudo, (int) $admin] );
        return (int) getConnexion()->lastInsertId();
    }

    function createArticle(string $title, string $description, string $date, int $idUser, array $selectedCategories) : bool {
        $connexion = getConnexion();
        try {
            $connexion->beginTransaction();

            $stmtArticle = $connexion->prepare("INSERT INTO Article (titre, description, date, idUser) VALUES (?, ?, ?, ?)");
            $stmtArticle->execute([$title, $description, $date, $idUser]);

            $idArticle = (int) $connexion->lastInsertId();

            $stmtFk = $connexion->prepare("INSERT INTO article_categorie (idArticle, idCategorie) VALUES (?, ?)");
            foreach ($selectedCategories as $idCategorie) {
                $stmtFk->execute([$idArticle, (int) $idCategorie]);
            }

            $connexion->commit();

            header("Location: /TPBlog/index.php");
            exit;
        } catch( PDOException $exception ) {
            echo "Erreur SQL : " . $exception->getMessage() . "<br/>";
            if( $connexion->inTransaction() ){
                $connexion->rollBack();
            }
            return false;
        }
        return true;
    }
?>
