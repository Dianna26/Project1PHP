<?php

include './database/db.php';

session_start();

$con = connectToDatabase();

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
    $_SESSION['rol'] = $finalResult['rol'];
    $_SESSION['name'] = $finalResult['nume'];
    $_SESSION['id'] = $finalResult['id_utilizator'];
    echo 'Bine ati venit' . $_SESSION['name'] . '!';
    header('Location: home/home.php');
}

// if (password_verify($_POST['password'], $password)) 
$stmt->close();
