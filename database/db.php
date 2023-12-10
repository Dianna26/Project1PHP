<?php

function connectToDatabase()
{
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

    return $con;
}

function getAllApprovedArticles()
{
    $con = connectToDatabase();
    $stmt = $con->prepare('
    SELECT articole.*, categorii.nume_categorie
    FROM articole
    JOIN categorii ON articole.id_categorie = categorii.id_categorie
    WHERE aprobat = 1
    ');
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Returneaza o lista cu toate articolele pentru un anumit utilizator si rol.
 * Pentru editori toate sunt returnate.
 * Pentru jurnalisti, doar cele aprobate sau cele personale.
 * Pentru orice alt utilizator, cele aprobate.
 * @param $rol string Rolul utilizatorului.
 * @param $id integer Id-ul utilizatorului.
 * @return array Lista cu articole.
 */
function getAllArticles($rol, $id)
{
    $con = connectToDatabase();
    $sql = '
    SELECT articole.*, categorii.nume_categorie
    FROM articole
    JOIN categorii ON articole.id_categorie = categorii.id_categorie
    ';

    switch ($rol) {
        case 'editor':
            // toate
            break;
        case 'jurnalist':
            // aprobate plus cele personale
            $sql .= '
                WHERE articole.aprobat = 1 
                OR articole.id_utilizator = ?
            ';
            break;
        default:
            // doar cele aprobate
            $sql .= '
                WHERE articole.aprobat = 1
            ';
            break;
    }

    $sql .= '
        ORDER BY articole.data_publicare DESC
    ';

    $stmt = $con->prepare($sql);

    if ($rol === 'jurnalist') {
        $stmt->bind_param('i', $id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllUnapprovedArticles()
{
    $con = connectToDatabase();
    $stmt = $con->prepare('
    SELECT articole.*, categorii.nume_categorie
    FROM articole
    JOIN categorii ON articole.id_categorie = categorii.id_categorie
    WHERE aprobat = 0
    ');
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

function approveArticle($articleId)
{
    $con = connectToDatabase();
    $stmt = $con->prepare('UPDATE articole SET aprobat = 1 WHERE id_articol = ?');
    $stmt->bind_param('i', $articleId);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

function getCategoryIDByName($categoryName)
{
    $con = connectToDatabase();
    $stmt = $con->prepare('SELECT id_categorie FROM categorii WHERE nume_categorie = ?');
    $stmt->bind_param('s', $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_categorie'];
    }
    return null;
}

function getArticleById($articleId)
{
    $con = connectToDatabase();
    $stmt = $con->prepare('SELECT a.*, c.nume_categorie FROM articole a
                          LEFT JOIN categorii c ON a.id_categorie = c.id_categorie
                          WHERE a.id_articol = ?');
    $stmt->bind_param('i', $articleId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
