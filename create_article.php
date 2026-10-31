<?php
    require_once __DIR__ . '/config/init.php';
    requirelogin();
    $connexion = getConnexion();

    $ErrorMsgTitre = null;
    $ErrorMsgDesc = null;
    $ErrorMsgCategories = null;
    $ErrorMsgCreateArticle = null;

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $selectedCategories = $_POST['categories'] ?? [];

    $stmtCategories = $connexion->query("SELECT idCategorie, nom FROM Categorie ORDER BY nom ASC");
    $allCategories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

    if( !empty($_POST) ) {
        if( empty($title) ) {
            $ErrorMsgTitre = "Le titre de l'article est obligatoire.";
        } elseif( mb_strlen($title) > 255 || mb_strlen($title) <= 5) {
            $ErrorMsgTitre = "Le titre doit être compris entre 5 et 255 caractères.";
        }

        if( empty($description) ) {
            $ErrorMsgDesc = "Le contenu de l'article ne peut pas être vide.";
        }

        if( empty($selectedCategories) || !is_array($selectedCategories) ) {
            $ErrorMsgCategories = "Veuillez sélectionner au moins une catégorie.";
        }

        if( !$ErrorMsgTitre && !$ErrorMsgDesc && !$ErrorMsgCategories ) {
            $idUser = $_SESSION['idUser'] ?? getIdByPseudo($_SESSION['pseudo']);
            if ( $idUser === 0 || $idUser === false ) {
                $ErrorMsgCreateArticle = "Erreur lors de la récupération des données utilisateur";
                exit;
            }
            $date = date('Y-m-d H:i:s');
            if( createArticle($title, $description, $date, $idUser, $selectedCategories) === false ) {
                $ErrorMsgCreateArticle = "Erreur lors de l'enregistrement de l'article.";
            }
        }
    }

    require_once __DIR__ . '/includes/header.php';
?>
    <main>
        <h1>Création d'un article</h1>
        <h3>Rédigez votre nouvel article</h3>

        <form method="POST">
            <div>
                <label for="title">Titre de l'article :</label><br/>
                <input type="text"  id="title" name="title" placeholder="Titre de votre article"
                    value="<?= htmlspecialchars($title) ?>" required autofocus >
                <br/>
                <?php showMsgErreur($ErrorMsgTitre, 'red', FontStyle::ITALIC); ?>
                <?php showMsgErreur($ErrorMsgCreateArticle, 'red', FontStyle::ITALIC); ?>
            </div>
            <br/>

            <div>
                <label for="description">Contenu de l'article :</label><br/>
                <textarea id="description" name="description" placeholder="Rédigez le texte de votre article ici..."
                    rows="8" cols="60" required>
                    <?= htmlspecialchars($description) ?>
                </textarea>
                <br/>
                <?php showMsgErreur($ErrorMsgDesc, 'red', FontStyle::ITALIC); ?>
            </div>
            <br/>

            <fieldset>
                <legend>Catégories (choisissez-en au moins une) :</legend>
                <?php if (empty($allCategories)): ?>
                    <p>Aucune catégorie disponible pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($allCategories as $cat): ?>
                        <label>
                            <input type="checkbox" name="categories[]" value="<?= (int) $cat['idCategorie'] ?>"
                                <?= in_array((string) $cat['idCategorie'], (array) $selectedCategories, true) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </label>
                        <br/>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php showMsgErreur($ErrorMsgCategories, 'red', FontStyle::ITALIC); ?>
            </fieldset>
            <br/>

            <button type="submit">Publier l'article</button>
        </form>
    </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>