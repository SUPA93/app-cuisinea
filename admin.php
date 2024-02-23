<?php
require_once('templates/header.php');
require_once('lib/category.php');
require_once('lib/user.php');

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}


?>
<h1>Gestion des utilisateurs</h1>

<?php if (isset($_SESSION['success_message'])) { ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message'] ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php }
?>

<?php if (isset($_SESSION['error_message'])) { ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message'] ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php }
?>
<a href="ajout_users.php" class="btn btn-primary m-4">Créer un nouvel utilisateur</a>
<form>
    <table class="table">
        <thead>
            <tr class="text-center">
                <th>Email</th>
                <th>identité</th>
                <th>Role</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr class="text-center">
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td class="text-center">
                        <a href="modifier_users.php?id=<?= $user['id']; ?>" class="btn btn-warning btn-edity">Modifier</a>
                    </td>
                    <td class="text-center">
                        <a href="lib/deleteUser.php?id=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</form>

<?php
require_once('templates/footer.php');
?>