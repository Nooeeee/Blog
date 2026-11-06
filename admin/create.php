<?php
require_once __DIR__ .'/../config/init.php';

requireAdmin();

$nom = '';
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valeurRecue = $_POST['nom'] ?? '';
    $nom = is_string($valeurRecue) ? trim($valeurRecue): '';

    if ($nom === '') {
        $erreur = 'Le nom de la catégorie est obligatoire.';
    } elseif (mb_strlen($nom) > 40) {
        $erreur = 'Le nom ne doit pas dépasser 40 caractères.';
    } elseif (createCategory($nom)) {
        header('Location: /TPBlog/admin/index.php');
        exit;
    } else {
        $erreur = "La catégorie n'a pas pu être créée.";
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Ajouter une catégorie</h1>

    <p><a href="/TPBlog/admin/index.php">Retour à la ligne</a></p>

    <form method="POST">
        <label for="nom">Nom de la catégorie :</label>
        <input
            type="text" id="nom" name="nom" maxlength="40" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>" required
        >
        <button type="submit">Ajouter</button>
    </form>

    <?php if ($erreur !== null): ?>
        <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
