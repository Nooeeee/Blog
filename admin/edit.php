<?php
require_once __DIR__ . '/../config/init.php';

requireAdmin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: /TPBlog/admin/index/php');
    exit;
}

$categorie = getCategoryById($id);

if ($categorie === false) {
    header('Location: /TPBlog/admin/index.php');
    exit;
}

$nom = $categorie['nom'];
$erreur = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valeurRecue = $_POST['nom'] ?? '';
    $nom = is_string($valeurRecue) ? trim($valeurRecue) : '';

    if ($nom === '') {
        $erreur = 'Le nom de la catégorie est obligatoire.';
    } elseif (mb_strlen($nom) > 40) {
        $erreur = 'Le nom ne doit pas dépasser 40 caractères.';
    } elseif (updateCategory($id, $nom)) {
        header('Location: /TPBlog/admin/index.php');
        exit();
    } else {
        $erreur = 'La catégorie n a pas pu être modifée.';
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Modifier une catégorie</h1>

    <p><a href="/TPBlog/admin/index.php">Revenir aux catégories</a></p>

    <form method="POST" action="/TPBlog/admin/edit.php?id=<?= (int) $id ?>">
        <label for="nom">Nom de la catégorie :</label>
        <input type="text" id="nom" name="nom" maxlength="40" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>"required>
        <button type="submit">Enregistrer</button>
    </form>

    <?php if ($erreur !== null): ?>
        <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
