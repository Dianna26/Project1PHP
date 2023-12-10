<?php
include '../database/db.php';

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../login/login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager de Articole</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <?php include '../navbar/index.php'; ?>

    <?php if (in_array($_SESSION['rol'], ['jurnalist', 'editor'])) : ?>
        <a href="../addArticle/index.php" class="button">Add Article</a>
    <?php endif; ?>


    <?php
    if ($_SESSION['rol'] === 'editor') : ?>
        <a href="../unapprovedArticles/index.php" class="button">Unapproved Articles</a>
    <?php endif; ?>

    <?php
    $articles = getAllArticles($_SESSION['rol'], $_SESSION['id_utilizator']);
    $readMoreArticleId = isset($_GET['read_more']) ? $_GET['read_more'] : null;

    foreach ($articles as $article) : ?>
        <div class="article">
            <h2><?php echo $article['titlu'] ?></h2>
            <p>
                <?php
                $max_length = 150;
                $content = $article['continut'];

                if (strlen($content) > $max_length) {
                    if ($readMoreArticleId == $article['id_articol']) {
                        echo '<span class="short-content" style="display:none;">' . substr($content, 0, $max_length) . '...</span>';
                        echo '<span class="full-content">' . $content . '</span>';
                        echo '<a href="?read_less=' . $article['id_articol'] . '" class="read-less-button">Read Less</a>';
                    } else {
                        echo '<span class="short-content">' . substr($content, 0, $max_length) . '...</span>';
                        echo '<a href="?read_more=' . $article['id_articol'] . '" class="read-more-button">Read More</a>';
                    }
                } else {
                    echo $content;
                }
                ?>
            </p>
            <p class="tag category"><?php echo $article['nume_categorie'] ?></p>
            <p class="tag publish-date"><?php echo $article['data_publicare'] ?></p>
            <?php if ($_SESSION['rol'] === 'editor') : ?>
                <a href="../editArticle/index.php?article_id=<?php echo $article['id_articol']; ?>" class="edit-button">Edit</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>

</html>