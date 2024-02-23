<?php

require_once('templates/header.php');
require_once('lib/user.php');
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$user = getUserById($pdo, $_GET['id']);

$errors = [];
$messages = [];

if (isset($_POST['updateUser'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role = $_POST['role'];

    if (!empty($email) && !empty($password) && !empty($first_name) && !empty($last_name) && !empty($role)) {
        $res = updateUser(
            $pdo,
            $_GET['id'],
            $_POST['email'],
            $_POST['password'],
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['role']
        );
        if ($res === true) {
            $_SESSION['success_message'] = 'L\'utilisateur a été modifié';
            header('Location: admin.php');
            exit;
        } else {
            $errors[] = 'Un problème est survenu';
        }
    }
}
?>

<h1>Modifier l'utilisateur</h1>

<?php foreach ($errors as $key => $error) { ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" id="email" class="form-control" value="<?= $user['email'] ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="text" name="password" id="password" class="form-control" value="<?= $user['password'] ?>">
    </div>
    <div class="mb-3">
        <label for="first_name" class="form-label">Prénom</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $user['first_name'] ?>">
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Nom</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $user['last_name'] ?>">
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select name="role" id="role" class="form-select">
            <option value="subscriber">Subscriber</option>
            <option value="administrateur">Administrateur</option>
        </select>
    </div>

    <input type="submit" value="Enregistrer" name="updateUser" class="btn btn-primary">

</form>

<?php
require_once('templates/footer.php');
?>