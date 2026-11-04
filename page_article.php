<?php
    require_once __DIR__ . '/config/init.php';
    requireLogin();

    $idArticle = (int) ($_GET['idArticle'] ?? 0);
    $description = '';
    $comments = [];

    $errorMsgReleaseComment = null;
    $errorMsgDataNotFound = null;
    $errorMsgEmptyComment = null;
    $errorMsgDelete = null;

    $confirmationMsgReleaseComment = null;
    $confirmationMsgDelete = null;

    $currentUserId = (int) ($_SESSION['idUser'] ?? 0);
    $currentUserIsAdmin = isAdmin();

    // Suppression d'un article
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {
        $idArticleToDelete = (int) $_POST['delete_article'];

        if ( deleteArticle($idArticleToDelete, $currentUserId, $currentUserIsAdmin) ) {
            header("Location: /TPBlog/index.php");
            exit;
        } else {
            $errorMsgDelete = "Vous n'avez pas les droits pour supprimer cet article.";
        }
    }

    // Suppression d'un commentaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
        $idCommentToDelete = (int) $_POST['delete_comment'];

        if ( deleteCommentaire($idCommentToDelete, $currentUserId, $currentUserIsAdmin) ) {
            $confirmationMsgDelete = "Le commentaire a bien été supprimé.";
        } else {
            $errorMsgDelete = "Vous n'avez pas les droits pour supprimer ce commentaire.";
        }
    }

    // Création de commentaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
        $description = trim($_POST['description'] ?? '');
        $idUser = $_SESSION['idUser'] ?? getIdByPseudo($_SESSION['pseudo']);

        if ( !empty($idUser) && !empty($idArticle) && !empty($description) ) {
            $date = date('Y-m-d H:i:s');

            // insertion dans la bdd
            if( createComment($description, $date, $idArticle, $idUser) ) {
                $confirmationMsgReleaseComment = "Votre commentaire a été publié avec succès !";
                $description = '';
            } else {
                $errorMsgReleaseComment =  "Erreur lors de la publication du commentaire.";
            }
        } elseif ( empty($description) ) {
            $errorMsgEmptyComment = "Veuillez entrer un message pour publier votre commentaire.";
        } else {
            $errorMsgDataNotFound = "Erreur lors de la récupération des données.";
        }
    }

    // Récupération des données
    $article = getArticle($idArticle);
    if ( !empty($article) ) {
        $comments = getCommentsFromArticle($idArticle);
    }
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>
    <main>
        <?php if ( empty($article) ):
            showMsgErreur($errorMsgDataNotFound);
            showMsgErreur($errorMsgDelete);
        else:
            $userPseudo = getPseudoById($article['idUser']);
            $dateArticle = date( DATE_FORMAT_DISPLAY, strtotime($article['date']) );
        ?>
        <article>
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <p>Publié par <?=mb_strtoupper(htmlspecialchars($userPseudo))?>, le <?=$dateArticle?></p>

            <div class="article-body">
                <p><?= nl2br(htmlspecialchars($article['description'])) ?></p>
            </div>

            <?php if ( $currentUserIsAdmin || (int) $article['idUser'] === $currentUserId ): ?>
                <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');">
                    <button type="submit" name="delete_article" value="<?= (int) $article['idArticle'] ?>">Supprimer l'article</button>
                </form>
            <?php endif; ?>
        </article>

        <hr>
        <section class="comments-section">
            <h3>Commentaires</h3>
            <?php
                showMsgErreur($errorMsgReleaseComment);
                showMsgErreur($errorMsgDataNotFound);
                showMsgErreur($errorMsgEmptyComment);
                showMsgErreur($errorMsgDelete);
                if ( !empty($confirmationMsgReleaseComment) ){
                    showMsgErreur($confirmationMsgReleaseComment, 'green');
                }
                if ( !empty($confirmationMsgDelete) ){
                    showMsgErreur($confirmationMsgDelete, 'green');
                }
            ?>
            <form method="POST">
                <div>
                    <label for="description">Ajouter un commentaire</label><br/>
                    <textarea id="description" name="description"
                              placeholder="Rédigez le texte de votre commentaire ici..."
                              rows="4"
                              cols="60" required>
                        <?= htmlspecialchars($description) ?>
                    </textarea>
                    <br/>
                </div>
                <button type="submit" name="submit_comment">Publier le commentaire</button>
            </form>
            <br/>
            <div class="comments-list">
                <?php
                    if ( empty($comments) ): ?>
                        <p>Aucun commentaire publié pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment):
                            $commentAuthor = getPseudoById($comment['idUser']);
                            $commentDate =  date( DATE_FORMAT_DISPLAY, strtotime($comment['date']) );
                        ?>
                        <article class="comment">
                            <strong><?= mb_strtoupper(htmlspecialchars($commentAuthor)) ?></strong>,
                            le <?= htmlspecialchars($commentDate) ?>
                            <p><?= nl2br(htmlspecialchars($comment['description'])) ?></p>

                            <?php if ( $currentUserIsAdmin || (int) $comment['idUser'] === $currentUserId ): ?>
                                <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');">
                                    <button type="submit" name="delete_comment" value="<?= (int) $comment['idCommentaire'] ?>">Supprimer le commentaire</button>
                                </form>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
