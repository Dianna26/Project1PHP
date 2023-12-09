<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'article_management';

$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);

if (mysqli_connect_errno()) {
    exit('Esec conectare MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['email'], $_POST['password'])) {
    exit('Completati email si password !');
}


$stmt = $con->prepare('SELECT * FROM utilizatori WHERE email = ?');
$stmt->bind_param('s', $_POST['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    exit('Utilizator inexistent in baza de date!');
}

$finalResult = $result->fetch_assoc();

if ($_POST['password'] === $finalResult['parola']) {
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['email'] = $finalResult['email'];
    $_SESSION['name'] = $finalResult['nume'];
    $_SESSION['id'] = $finalResult['id_utilizator'];
    echo 'Bine ati venit' . $_SESSION['name'] . '!';
    // header('Location: home.php');
}

// if (password_verify($_POST['password'], $password)) 
$stmt->close();
