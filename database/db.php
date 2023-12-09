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

    $finalResult = $result->fetch_all(MYSQLI_ASSOC);
    return $finalResult;
}

function getAllArticles()
{
    $con = connectToDatabase();
    $stmt = $con->prepare('
    SELECT articole.*, categorii.nume_categorie
    FROM articole
    JOIN categorii ON articole.id_categorie = categorii.id_categorie
    ');
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [];
    }

    $finalResult = $result->fetch_all(MYSQLI_ASSOC);
    return $finalResult;
}
