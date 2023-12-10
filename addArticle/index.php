<?php
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
    <title>Manager de Articole</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <div>
        <?php
        include '../navbar/index.php';
        ?>
    </div>
    <form action="add_article.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="artistic">Artistic</option>
            <option value="technic">Technic</option>
            <option value="science">Science</option>
            <option value="moda">Moda</option>
        </select>

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required></textarea>

        <label for="publish_date">Publish Date:</label>
        <input type="date" id="publish_date" name="publish_date" required>

        <div class="button-container">
            <button type="button" class="back-btn" onclick="window.history.back()">Back</button>
            <button type="submit">Add Article</button>
        </div>
    </form>
</div>
</body>

</html>