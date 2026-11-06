<?php
require_once __DIR__ . '/../config/init.php';

requireAdmin();

$categories = getAllCategories();

require_once __DIR__ . '/../includes/header.php';
?>

<main>
    <h1>Gestion des catégories</h1>

    <p><a class="bouton" href="/TPBlog/admin/create.php">Ajouter une catégorie</a></p>

    <?php if (empty($categories)): ?>
        <p>Aucune catégorie pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($categories as $categorie): ?>
                <li>
                    <?= htmlspecialchars($categorie['nom'], ENT_QUOTES, 'UTF-8') ?>
                    <a href="/TPBlog/admin/edit.php?id=<?= (int) $categorie['idCategorie'] ?>">Modifier</a>

                    <form method="POST" action="/TPBlog/admin/delete.php">
                        <input type="hidden" name ="id" value="<?= (int) $categorie['idCategorie'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
