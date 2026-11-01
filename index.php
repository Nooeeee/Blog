<?php
    require_once __DIR__ . '/config/init.php';
    const MAX_ARTICLE_PREVIEW_CHARACTERS = 705;
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
                    $articleBody = mb_strlen($article['description']) > MAX_ARTICLE_PREVIEW_CHARACTERS ?
                        mb_substr($article['description'], 0, MAX_ARTICLE_PREVIEW_CHARACTERS) . '...  ' : $article['description'];
                    ?>
                    <article>
                        <h3><?=  htmlspecialchars($article['titre']) ?></h3>
                        <?php
                            if ( !empty($dateArticle) && !empty($userPseudo)): ?>
                                <p>Publié par <?= mb_strtoupper(htmlspecialchars($userPseudo))?>, le <?=$dateArticle?></p>
                        <?php endif;
                            if ( !empty($articleBody) && mb_strlen($articleBody) > MAX_ARTICLE_PREVIEW_CHARACTERS ):?>
                                <p>
                                    <?= nl2br(htmlspecialchars($articleBody)) // 'nl2br' = garder les sauts à la ligne
                                    ?><a href="/TPBlog/page_article.php?idArticle=<?= (int) $article['idArticle'] ?>">Voir la suite</a>
                                </p>
                            <?php elseif ( !empty($articleBody) && mb_strlen($articleBody) <= MAX_ARTICLE_PREVIEW_CHARACTERS): ?>
                                    <?= nl2br(htmlspecialchars($articleBody)) ?>
                            <?php else:
                                    showMsgErreur($errorMsgNoAvailable);
                            endif; ?>
                        <footer>
                            <?php
                                if ( $totalComments  !== null ): ?>
                                    <a href="/TPBlog/page_article.php?idArticle=<?= (int) $article['idArticle'] ?>"> <?=$totalComments?> commentaire(s)</a>
                            <?php endif; ?>
                        </footer>
                    </article>
                <?php endforeach;
        endif; ?>
                </section>
        <br/>

        <nav class="pages">
            <?php if ( $currentPage > 1 ): ?>
                <a href="/TPBlog/index.php?page=<?= $currentPage - 1 ?>">Page Précédente</a>
            <?php endif; ?>

            <?php
            $startingPage = max(1, $currentPage - 2);
            $endingPage = min($nbTotalPages, $currentPage + 2);
            for ($i = $startingPage; $i <= $endingPage; $i++):
                if ( $i === $currentPage ):?>
                <a href="/TPBlog/index.php?page=<?= $i ?>"><strong><?= $i ?></strong></a>
                <?php else: ?>
                    <a href="/TPBlog/index.php?page=<?= $i ?>"><?= $i ?></a>
            <?php endif;
            endfor; ?>

            <?php if ( $currentPage < $nbTotalPages ): ?>
                <a href="/TPBlog/index.php?page=<?= $currentPage + 1 ?>">Page Suivant</a>
            <?php endif; ?>
        </nav>
    </main>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
