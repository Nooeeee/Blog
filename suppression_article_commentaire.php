<?php
    require_once __DIR__ . '/config/init.php';
    require_login;

$idArticle = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

$current_user_id = $_SESSION['idUser'] ?? 0;
$is_admin  = $_SESSION['is_admin'] ?? false;

if(isset($_GET['delete_com'])){
    $com_id = (int)$_GET['delete_com'];
    $delete_commentaire = deleteCommentaire($idCommentaire)
    $message = "Le commentaire à bien été supprimé.";
} else {
    $message = "Vous n'avez pas les droits pour supprimer ce commentaire.";
    }
}

if(isset($_GET['delete_article'])){
    $article_id = (int)$_GET['delete_article'];
    $delete_article = deleteArticle($idArticle);
    $message = "L'article' à bien été supprimé.";

} else {
    $message = "Vous n'avez pas les droits pour supprimer cet article.";
    }
}

$recuperationArticleEtCommentaire($idArticle, $idCommentaire, $idUser);
?>