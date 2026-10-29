<?php
    require_once __DIR__ . '/config/init.php';

    $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $message = '';

 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_commentaire'])) {
     $description = trim($_POST['description'] ?? '');
     $user_id = $_SESSION['user_id'] ?? 0;

     if (!empty($description) && $user_id > 0) {
         $stmt = $pdo->prepare('INSERT INTO commentaire (article_id, user_id, description, date) VALUES (?, ?, ?, NOW())');
         $stmt->execute([$article_id, $user_id, $description]);
         $message = "Votre commentaire a été publié avec succès !";
     } else {
         $message = "Veuillez écrire un commentaire et être connecté.";
     }
 }

$stmt = $pdo-> prepare('SELECT * FROM article WHERE idArticle ? ');
$stmt->execute([$article_id]);
$article =$stmt->fetch();

$stmtCom = $pdo->prepare('SELECT c.*, u.pseudo FROM commentaire c JOIN user u ON c.user_id = u.id WHERE c.article_id = ? ORDER BY c.date DESC');
$stmtCom->execute([$article_id]);
$commentaires = $stmtCom->fetchAll();
?>
faut enlever cela...