<?php
require_once ('./lib/session.php');
require_once ('./lib/menu.php');
require_once ('./lib/pdo.php'); 
require_once ('./lib/recipe.php');
require_once ('./lib/tools.php');
require_once ('./lib/user.php'); 

$users = getAllUsers($pdo);
$currentPage = basename($_SERVER['SCRIPT_NAME']);

?> 
<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Partagez vos recettes de cuisine facilement en un instant pour le plaisir de la gourmandise! ">
    <title>Cuisinea</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/override-bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>

<body>

    <!-- Header -->
    <header class="d-flex flex-wrap align-items-center justify-content-center mb-4 border-bottom">
        <a href="index.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img id="logo" src="assets/images/logo-cuisinea-horizontal.jpg" alt="Logo Cuisinea" width="250">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0 nav nav-pills">
            <?php foreach ($mainMenu as $key => $value) { ?>
                <?php
                if (($key === 'gestion_recette.php' || $key === 'admin.php') && !isset($_SESSION['user'])) {
                    continue;
                }
                ?>
                <li class="nav-item"><a href="<?= $key; ?>" class="nav-link <?php if ($currentPage === $key) {
                                                                                echo 'active';
                                                                            } ?>"><?= $value; ?></a></li>
            <?php } ?>
        </ul>

        <div class="col-md-3 text-end">
            <?php if (!isset($_SESSION['user'])) { ?>
                <a href="login.php" class="btn btn-outline-primary me-2">Se connecter</a>
                <a href="inscription.php" class="btn btn-outline-primary me-2">S'inscrire</a>
            <?php } else { ?>
                <a id="logoutBtn" href="logout.php" class="btn btn-primary">Se déconnecter</a>
            <?php } ?>

        </div>
    </header>