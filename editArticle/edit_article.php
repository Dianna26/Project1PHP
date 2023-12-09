<?php
include '../database/db.php';

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] !== 'jurnalist') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'];
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $publishDate = filter_input(INPUT_POST, 'publish_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $con = connectToDatabase();
    $stmt = $con->prepare('UPDATE articole SET id_categorie = ?, titlu = ?, continut = ?, data_publicare = ? WHERE id_articol = ?');
    $stmt->bind_param('isssi', getCategoryIDByName($category), $title, $content, $publishDate, $articleId);

    if ($stmt->execute()) {
        header('Location: ../home/home.php');
        exit;
    } else {
        echo 'Error: ' . $stmt->error;
    }
}
