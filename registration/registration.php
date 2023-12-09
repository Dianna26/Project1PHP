<?php
// Schimbați acest lucru cu informațiile despre conexiune.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'magazin';

// Încerc să mă conectez pe baza informațiilor de mai sus.

$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);

if (mysqli_connect_errno()) {
    // Dacă există o eroare la conexiune, opriți scriptul și afișați eroarea.
    exit('Nu se poate conecta la MySQL: ' . mysqli_connect_error());
}

// Verificați dacă toate câmpurile necesare sunt trimise prin POST.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Nu s-au putut obține datele care ar fi trebuit trimise.
    exit('Completați formularul de înregistrare!');
}

// Asigurați-vă că valorile trimise prin POST nu sunt goale.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    // Unul sau mai multe câmpuri sunt goale.
    exit('Completați formularul de înregistrare!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Adresa de email nu este validă!');
}

if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('Numele de utilizator nu este valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Parola trebuie să aibă între 5 și 20 de caractere!');
}

// Verificăm dacă contul utilizatorului există.
if ($stmt = $con->prepare('SELECT id, password FROM utilizatori WHERE username = ?')) {
    // Hash parola folosind funcția PHP password_hash.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Memorăm rezultatul, astfel încât să putem verifica dacă contul există în baza de date.

    if ($stmt->num_rows > 0) {
        // Numele de utilizator există.
        echo 'Numele de utilizator există, alegeți altul!';
    } else {
        if ($stmt = $con->prepare('INSERT INTO utilizatori (username, parola, email) VALUES (?, ?, ?)')) {
            // Nu dorim să stocăm parole în clar în baza de date, așa că hash parola și utilizăm
            // password_verify atunci când un utilizator se autentifică.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo 'Înregistrare cu succes!';

            header('Location: index.html');
        } else {
            // Ceva nu este în regulă cu declarația SQL, verificați pentru a vă asigura că tabelul utilizatori există cu toate cele 3 câmpuri.
            echo 'Nu se poate pregăti declarația SQL!';
        }
    }
    $stmt->close();
} else {
    // Ceva nu este în regulă cu declarația SQL, verificați pentru a vă asigura că tabelul utilizatori există cu toate cele 3 câmpuri.
    echo 'Nu se poate pregăti declarația SQL!';
}
$con->close();
?>
