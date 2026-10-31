<?php
    function getConnexion(): PDO {
        static $connexion = null; // singleton

        if ($connexion === null) {
            try {
                $connexion = new PDO('mysql:host=localhost;dbname=TP_blog', 'root', '',
                    [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            } catch (Exception $e) {
                die("Erreur connexion à la base de données" . $e->getMessage());
            }
        }

        return $connexion;
    }

    function getUserByEmail(string $email) {
        $stmt = getConnexion()->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    function getPseudoById(int $idUser) : string {
        $stmt = getConnexion()->prepare("SELECT pseudo FROM user WHERE idUser=?");
        $stmt->execute([$idUser]);

        return $stmt->fetchColumn();
    }

    function getIdByPseudo(string $pseudo) : int {
        $stmt = getConnexion()->prepare("SELECT idUser FROM user WHERE pseudo=?");
        $stmt->execute([$pseudo]);

        return $stmt->fetchColumn();
    }

    function getArticlesByPage(int $page = 1): array {
        $page = max(1, $page);

        // (page - 1) => 1ère page = pas de décalage ; 2ème page => (2-1)*5 = 5 articles de décalage
        $offset = ($page - 1) * 5;

        $stmt = getConnexion()->prepare("SELECT * FROM article ORDER BY idArticle DESC LIMIT 5 OFFSET :offset");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    function getTotalArticles(): int {
        $stmt = getConnexion()->query("SELECT COUNT(idArticle) AS nbArticles FROM article");
        return (int) $stmt->fetchColumn();
    }

    function getTotalComments(int $idArticle): int {
        $stmt = getConnexion()->query("SELECT COUNT(idCommentaire) FROM commentaire WHERE idArticle=$idArticle");
        return (int) $stmt->fetchColumn();
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
            // insertion de l'article dans sa table
            $idArticle = insertArticle($title, $description, $date, $idUser);

            // insertion dans table servant de liaison (Article / Catégorie)
            attachArticleToCategorie($idArticle, $selectedCategories);

            $connexion->commit();

            header("Location: /TPBlog/index.php");
            return true;
        } catch( PDOException $exception ) {
            echo "Erreur SQL : " . $exception->getMessage() . "<br/>";
            if( $connexion->inTransaction() ){
                $connexion->rollBack();
            }
            return false;
        }
    }

    function insertArticle(string $title, string $description, string $date, int $idUser): int {
        $stmtArticle = getConnexion()->prepare("INSERT INTO Article (titre, description, date, idUser) VALUES (?, ?, ?, ?)");
        $stmtArticle->execute([$title, $description, $date, $idUser]);

        return (int) getConnexion()->lastInsertId();
    }

    function attachArticleToCategorie(int $idArticle, array $selectedCategories): void {
        $stmtFk = getConnexion()->prepare("INSERT INTO article_categorie (idArticle, idCategorie) VALUES (?, ?)");

        foreach ($selectedCategories as $idCategorie) {
            $stmtFk->execute([$idArticle, (int) $idCategorie]);
        }
    }
?>
