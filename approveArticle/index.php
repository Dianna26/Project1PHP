<?php
include '../database/db.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: navbar.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Article Management</title>
    <link rel="stylesheet" href="approveArticle.css">
</head>

<body>
    <div class="container">


        <?php
        $articles = getAllUnapprovedArticles();

        foreach ($articles as $article) : ?>
            <div class="button-container">
                <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
            </div>
            <div class="article">
                <h2><?php echo $article['titlu'] ?></h2>
                <p><?php echo $article['continut']  ?></p>
                <p><?php echo $article['nume_categorie']  ?></p>
                <p class="publish-date"><?php echo $article['data_publicare']  ?></p>
                <?php
                if ($_SESSION['rol'] === 'editor') : ?>
                    <form action="approveArticle.php" method="POST">
                        <input type="hidden" name="article_id" value="<?php echo $article['id_articol']; ?>">
                        <button class="approve-button" type="submit">Approve</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>