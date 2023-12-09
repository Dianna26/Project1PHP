<?php
include '../database/db.php';

session_start();
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        // Display the button for users with the role "jurnalist"
        if ($_SESSION['rol'] === 'jurnalist') : ?>
            <a href="../addArticle/index.php" class="button">Add Article</a>
        <?php endif; ?>

        <?php
        $articles = getAllArticles();

        foreach ($articles as $article) : ?>
            <div class="article">
                <h2><?php echo $article['titlu'] ?></h2>
                <p><?php echo $article['continut']  ?></p>
                <p><?php echo $article['nume_categorie']  ?></p>
                <p class="publish-date"><?php echo $article['data_publicare']  ?></p>
                <?php
                if ($_SESSION['rol'] === 'jurnalist') : ?>
                    <a href="../editArticle/index.php?article_id=<?php echo $article['id_articol']; ?>" class="edit-button">Edit</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>


    </div>
</body>

</html>