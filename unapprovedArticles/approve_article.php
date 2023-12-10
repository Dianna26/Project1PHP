<?php
include '../database/db.php';

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] !== 'editor') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'];
    if (approveArticle($articleId) === true) {
        header('Location: ../home/home.php');
    } else {
        echo "Aprobarea nu a avut succes!";
    }
}
