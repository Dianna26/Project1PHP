<?php

include '../database/db.php';

session_start();

$con = connectToDatabase();

$stmt = $con->prepare('
    SELECT u.*, r.* 
    FROM utilizatori u 
    INNER JOIN roluri r ON u.rol_id = r.id 
    WHERE u.nume = ?
');
$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 0) {
    exit('Utilizator inexistent in baza de date!');
}

$finalResult = $result->fetch_assoc();

if (password_verify($_POST['password'], $finalResult['parola'])) {
    session_regenerate_id();
    $_SESSION['loggedin'] = TRUE;
    $_SESSION['email'] = $finalResult['email'];
    $_SESSION['rol'] = $finalResult['rol'];
    $_SESSION['name'] = $finalResult['nume'];
    $_SESSION['id_utilizator'] = $finalResult['id'];
    echo 'Bine ati venit' . $_SESSION['name'] . '!';
    header('Location: ../home/home.php');
}

$stmt->close();
