<?php
include '../database/db.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// if ($_SESSION['rol'] !== 'editor') {
//     // Redirect users without editor role
//     header('Location: index.php');
//     exit;
// }

// Check if article_id is provided in the URL
if (!isset($_GET['article_id']) || !is_numeric($_GET['article_id'])) {
    // Redirect if article_id is not provided or is not a valid number
    header('Location: index.php');
    exit;
}

$articleId = $_GET['article_id'];

$article = getArticleById($articleId);

if (!$article) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager de Articole</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <h1>Edit Article</h1>

    <?php if (isset($error_message)) : ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="edit_article.php" method="POST">
        <input type="hidden" name="article_id" value="<?php echo $articleId; ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $article['titlu']; ?>" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="artistic" <?php echo ($article['nume_categorie'] === 'artistic') ? 'selected' : ''; ?>>
                Artistic
            </option>
            <option value="technic" <?php echo ($article['nume_categorie'] === 'technic') ? 'selected' : ''; ?>>
                Technic
            </option>
            <option value="science" <?php echo ($article['nume_categorie'] === 'science') ? 'selected' : ''; ?>>
                Science
            </option>
            <option value="moda" <?php echo ($article['nume_categorie'] === 'moda') ? 'selected' : ''; ?>>Moda</option>
        </select>

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required><?php echo $article['continut']; ?></textarea>

        <label for="publish_date">Publish Date:</label>
        <input type="date" id="publish_date" name="publish_date" value="<?php echo $article['data_publicare']; ?>"
               required>


        <div class="button-container">
            <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
<!--            <button type="submit">Update Article</button>-->
            <form action="../home/home.php" method="post">
                <button type="submit">Update Article</button>
            </form>
        </div>
    </form>
</div>
</body>

</html>