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

    function getAllCategories(): array {
        $stmt = getConnexion()->query("SELECT idCategorie, nom FROM categorie ORDER BY nom ASC");

        return $stmt->fetchAll();
    }

    function createCategory(string $name): bool {
        $stmt = getConnexion()->prepare("INSERT INTO categorie (nom) VALUES (?)");

        return $stmt->execute([$name]);
    }

    function getCategoryById(int $id) : array|false {
        $stmt = getConnexion()->prepare("SELECT idCategorie, nom FROM categorie WHERE idCategorie = ?");
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    function updateCategory(int $id, string $name) : bool  {
        $stmt = getConnexion()->prepare("UPDATE Categorie SET nom = ? WHERE idCategorie = ?");

        return $stmt->execute([$name, $id]);
    }

    function deleteCategory(int $id) : bool {
        $stmt = getConnexion()->prepare("DELETE FROM categorie WHERE idCategorie = ?");

        return $stmt->execute([$id]);
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

    // Récupère les 5 articles les plus récents de la page donnée
    function getArticlesByPage(int $page = 1): array {
        $page = max(1, $page);

        // (page - 1) => 1ère page = pas de décalage ; 2ème page => (2-1)*5 = 5 articles de décalage
        $offset = ($page - 1) * 5;

        $stmt = getConnexion()->prepare("SELECT * FROM article ORDER BY idArticle DESC LIMIT 5 OFFSET :offset");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Récupère le nombre total d'articles dans la base de données
    function getTotalArticles(): int {
        $stmt = getConnexion()->query("SELECT COUNT(idArticle) AS nbArticles FROM article");
        return (int) $stmt->fetchColumn();
    }

    // Récupère le nombre de commentaires d'un article
    function getArticlesFromUser(string $idUser): array {
        $stmt = getConnexion()->query("SELECT * FROM article WHERE idUser=?");
        $stmt->execute([$idUser]);

        return $stmt->fetchAll();
    }

    // Récupère le nombre de commentaires d'un article
    function getTotalComments(int $idArticle): int {
        $stmt = getConnexion()->query("SELECT COUNT(idCommentaire) FROM commentaire WHERE idArticle=$idArticle");
        return (int) $stmt->fetchColumn();
    }

    // Récupère l'Article spécifié
    function getArticle(int $idArticle): array|false {
        $stmt = getConnexion()->prepare("SELECT * FROM Article WHERE idArticle=?");
        $stmt->execute([$idArticle]);

        return $stmt->fetch();
    }

    // Récupère tous les commentaires de l'Article spécifié
    function getCommentsFromArticle(int $idArticle): array{
        $stmt = getConnexion()->prepare("SELECT * FROM Commentaire WHERE idArticle=?");
        $stmt->execute([$idArticle]);

        return $stmt->fetchAll();
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

            return true;
        } catch( PDOException ) {
            if( $connexion->inTransaction() ){
                $connexion->rollBack();
            }
            return false;
        }
    }

    // renvoie l'ID de l'Article
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

    function createComment(string $description, string $date, int $idArticle, int $idUser): bool {
        $connexion = getConnexion();
        try {
            $connexion->beginTransaction();

            // insertion du commentaire dans sa table
            insertComment($description, $date, $idArticle, $idUser);
            $connexion->commit();

            return true;
        } catch( PDOException) {
            if( $connexion->inTransaction() ){
                $connexion->rollBack();
            }
            return false;
        }
    }

    function insertComment(string $description, string $date, int $idArticle, int $idUser): void {
        $stmtComment = getConnexion()->prepare("INSERT INTO Commentaire (description, date, idArticle, idUser) VALUES (?, ?, ?, ?)");
        $stmtComment->execute([$description, $date, $idArticle, $idUser]);
    }

    // Supprime un article (et ses commentaires / catégories grâce au ON DELETE CASCADE)
    // Seul l'auteur de l'article ou un admin peut le supprimer
    function deleteArticle(int $idArticle, int $idUser, bool $isAdmin): bool {
        $stmtCheck = getConnexion()->prepare("SELECT idUser FROM Article WHERE idArticle = ?");
        $stmtCheck->execute([$idArticle]);
        $article = $stmtCheck->fetch();

        if ($article === false) {
            return false;
        }

        if ((int) $article['idUser'] !== $idUser && !$isAdmin) {
            return false;
        }

        $stmtDel = getConnexion()->prepare("DELETE FROM Article WHERE idArticle = ?");

        return $stmtDel->execute([$idArticle]);
    }

    // Supprime un commentaire
    // Seul l'auteur du commentaire ou un admin peut le supprimer
    function deleteCommentaire(int $idCommentaire, int $idUser, bool $isAdmin): bool {
        $stmtCheck = getConnexion()->prepare("SELECT idUser FROM Commentaire WHERE idCommentaire = ?");
        $stmtCheck->execute([$idCommentaire]);
        $commentaire = $stmtCheck->fetch();

        if ($commentaire === false) {
            return false;
        }

        if ((int) $commentaire['idUser'] !== $idUser && !$isAdmin) {
            return false;
        }

        $stmtDel = getConnexion()->prepare("DELETE FROM Commentaire WHERE idCommentaire = ?");

        return $stmtDel->execute([$idCommentaire]);
    }
