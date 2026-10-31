<?php
    require_once __DIR__ . '/config/init.php';

    requireLogin();
?>

<?php
    $currentPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ? : 1;
    if ( $currentPage < 1 ) {
        $currentPage = 1;
    }

    $articles = getArticlesByPage($currentPage);
    $nbTotalPages = (int) ceil(getTotalArticles() / 5);

    $errorMsgNoAvailable = 'Contenu indisponible';
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>
    <main>
        <h1>Accueil</h1>
        <h2>Articles récents</h2>

        <?php
            if ( empty($articles) ): ?>
                <p>Aucun article n'a été publié pour le moment.</p>
        <?php else: ?>
                <section class="list-articles">
        <?php
                foreach ( $articles as $article ):
                    $userPseudo = getPseudoById($article['idUser']);
                    $dateArticle = date( DATE_FORMAT_DISPLAY, strtotime($article['date']) );
                    $totalComments = getTotalComments($article['idArticle']);
                    $articleBody = strlen($article['description']) > 150 ?
                        mb_substr($article['description'], 0, 150) : $article['description'];

                    ?>
                    <article>
                        <h3><?=  htmlspecialchars($article['titre']) ?></h3>
                        <?php
                            if ( !empty($dateArticle) && !empty($userPseudo)): ?>
                                <p>Publié par <?= mb_strtoupper(htmlspecialchars($userPseudo))?>, le <?=$dateArticle?></p>
                        <?php endif;
                            if ( !empty($articleBody) ):?>
                                <p><?= nl2br(htmlspecialchars($article['description'])) // garder les sauts à la ligne 'nl2br' ?></p>
                            <?php else:
                                showMsgErreur($errorMsgNoAvailable);
                            endif; ?>
                        <footer>
                            <?php
                                if ( $totalComments  !== null ): ?>
                            <?=$totalComments?> commentaire(s)
                            <?php endif; ?>
                        </footer>
                    </article>
                    <?php endforeach;
                endif; ?>
                </section>
    </main>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
