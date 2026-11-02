<?php
require_once __DIR__ . '/../config/init.php';

requireAdmin();

$categories = getAllCategories();

require_once __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Gestion des catégories</h1>

    <?php if (empty($categories)): ?>
        <p>Aucune catégorie pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($categories as $categorie): ?>
                <li><?= htmlspecialchars($categorie['nom']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
