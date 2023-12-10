<?php
include '../database/db.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <?php
    include '../navbar/index.php';

    if ($_SESSION['rol'] === 1 || $_SESSION['rol'] === 3): ?>
        <a href="../addArticle/index.php" class="button">Add Article</a>
    <?php endif; ?>



    <?php
    if ($_SESSION['rol'] === 3) : ?>
        <a href="../unapprovedArticles/index.php" class="button">Unapproved Articles</a>
    <?php endif; ?>

    <?php
    $articles = getAllApprovedArticles();

    $readMoreArticleId = isset($_GET['read_more']) ? $_GET['read_more'] : null;

    foreach ($articles as $article) : ?>
        <div class="article">
            <h2><?php echo $article['titlu'] ?></h2>
            <p>
                <?php
                // Verificăm lungimea textului
                $max_length = 150; // Numărul maxim de caractere pentru afișare inițială
                $content = $article['continut'];

                if (strlen($content) > $max_length) {
                    if ($readMoreArticleId == $article['id_articol']) {
                        // Afișează conținutul complet și butonul "Read Less"
                        echo '<span class="short-content" style="display:none;">' . substr($content, 0, $max_length) . '...</span>';
                        echo '<span class="full-content">' . $content . '</span>';
                        echo '<a href="?read_less=' . $article['id_articol'] . '" class="read-less-button">Read Less</a>';
                    } else {
                        // Afișează doar o parte a textului și butonul "Read More"
                        echo '<span class="short-content">' . substr($content, 0, $max_length) . '...</span>';
                        echo '<a href="?read_more=' . $article['id_articol'] . '" class="read-more-button">Read More</a>';
                    }
                } else {
                    // Dacă textul nu depășește lungimea maximă, îl afișăm în întregime
                    echo $content;
                }
                ?>
            </p>
            <p><?php echo $article['nume_categorie'] ?></p>
            <p class="publish-date"><?php echo $article['data_publicare'] ?></p>
            <?php
            if ($_SESSION['rol'] === 'jurnalist') : ?>
                <a href="../editArticle/index.php?article_id=<?php echo $article['id_articol']; ?>" class="edit-button">Edit</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>

</html>