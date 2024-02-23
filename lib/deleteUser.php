<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('session.php');
require_once('pdo.php');
require_once('user.php');

if (isset($_GET['id'])) {
    $UserId = $_GET['id'];
    $success = deleteUser($pdo, $UserId);
}

if ($success) {
    $_SESSION['success_message'] = 'L\'utilisateur a bien été supprimée';
} else {
    $_SESSION['error_message'] = 'L\'utilisateur n\'a pas pu être supprimée';
}

header('Location: ../admin.php');
exit;
