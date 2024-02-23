<?php
require_once('templates/header.php');
require_once('lib/category.php');

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
$recipe = getRecipeById($pdo, $_GET['id']);
$categories = getCategories($pdo);

if (isset($_GET['id'])) {
    $recipe = getRecipeById($pdo, $_GET['id']);
    $categories = getCategories($pdo);
} else {
    header('location: gestion_recette.php');
}

$errors = [];
$messages = [];

if (isset($_POST['updateRecipe'])) {
    $fileName = null;
    if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
        $checkImage = getimagesize($_FILES['file']['tmp_name']);
        if ($checkImage !== false) {
            $fileName = uniqid() . '-' . slugify($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], _RECIPES_IMG_PATH_ . $fileName);
        } else {
            $errors[] = 'Le fichier doit être une image';
        }
    }

    $recipe = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'ingredients' => $_POST['ingredients'],
        'instructions' => $_POST['instructions'],
        'category_id' => $_POST['category']
    ];

    if (!$errors) {
        $res = updateRecipe(
            $pdo,
            $_GET['id'],
            $_POST['category'],
            $_POST['title'],
            $_POST['description'],
            $_POST['ingredients'],
            $_POST['instructions'],
            $fileName
        );
        if ($res === true) {
            $_SESSION['success_message'] = 'La recette a été modifié';
            header('Location: gestion_recette.php');
            exit;
        } else {
            $errors[] = 'Un problème est survenu';
        };
    }
}
?>

<h1>Modifier la recette</h1>

<?php foreach ($errors as $key => $error) { ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $recipe['title'] ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" cols="30" rows="5" class="form-control"><?= $recipe['description'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="ingredients" class="form-label">Ingredients</label>
        <textarea name="ingredients" id="ingredients" cols="30" rows="5" class="form-control"><?= $recipe['ingredients'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="instructions" class="form-label">Instructions</label>
        <textarea name="instructions" id="instructions" cols="30" rows="5" class="form-control"><?= $recipe['instructions'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Catégories</label>
        <select name="category" id="category" class="form-select">
            <?php foreach ($categories as $key => $category) { ?>
                <option value="<?= $category['id'] ?>" <?php if ($recipe['category_id'] == $category['id']) {
                                                            echo 'selected="selected"';
                                                        } ?>><?= $category['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Images</label>
        <input type="file" name="file" id="file">
    </div>

    <input type="submit" value="Enregistrer" name="updateRecipe" class="btn btn-primary">

</form>

<?php
require_once('templates/footer.php');
?>