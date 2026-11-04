<?php
    require_once __DIR__ . '/config/init.php';
    requireLogin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: /TPBlog/index.php");
        exit;
    }

    $currentUserId = (int) ($_SESSION['idUser'] ?? 0);
    $currentUserIsAdmin = isAdmin();
    $idArticle = (int) ($_POST['idArticle'] ?? 0);

    // Suppression d'un commentaire
    if (isset($_POST['delete_comment'])) {
        $idCommentaire = (int) $_POST['delete_comment'];

        deleteCommentaire($idCommentaire, $currentUserId, $currentUserIsAdmin);

        // retour sur la page de l'article
        header("Location: /TPBlog/page_article.php?idArticle=" . $idArticle);
        exit;
    }

    // Suppression d'un article
    if (isset($_POST['delete_article'])) {
        $idArticleToDelete = (int) $_POST['delete_article'];

        deleteArticle($idArticleToDelete, $currentUserId, $currentUserIsAdmin);

        // l'article n'existe plus, retour à l'accueil
        header("Location: /TPBlog/index.php");
        exit;
    }

    header("Location: /TPBlog/index.php");
    exit;
?>
