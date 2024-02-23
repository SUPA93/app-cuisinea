<?php

function getCategories(PDO $pdo)
{
    $sql = "SELECT * FROM categories";
    $query = $pdo->prepare($sql);

    $query->execute();
    return $query->fetchAll();
}

function getCategorieById(PDO $pdo, int $id)
{
    $query = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}
