<?php
include '../database/db.php';


session_start();
if (!isset($_SESSION['loggedin']) || ($_SESSION['rol'] !== 'jurnalist' && $_SESSION['rol'] !== 'editor')) {
    header('Location: ../home/home.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $publishDate = filter_input(INPUT_POST, 'publish_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $con = connectToDatabase();
    $stmt = $con->prepare('INSERT INTO articole (id_utilizator, id_categorie, titlu, continut, data_publicare, aprobat) VALUES (?, ?, ?, ?, ?, 0)');
    $stmt->bind_param('issss', $_SESSION['id'], getCategoryIDByName($category), $title, $content, $publishDate);

    if ($stmt->execute()) {
        header('Location: ../home/home.php');
    } else {
        echo 'Error: ' . $stmt->error;
    }

    exit;
}
