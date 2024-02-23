<?php
require_once('session.php');
require_once('pdo.php');
require_once('recipe.php');

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];
    $success = deleteRecipe($pdo, $recipeId);
}

if ($success) {
    $_SESSION['success_message'] = 'La recette a bien été supprimée';
} else {
    $_SESSION['error_message'] = 'La recette n\'a pas pu être supprimée';
}

header('Location: ../gestion_recette.php');
exit;
