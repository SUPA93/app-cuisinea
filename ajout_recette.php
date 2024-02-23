<?php
require_once('templates/header.php');

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

require_once('lib/tools.php');
require_once('lib/recipe.php');
require_once('lib/category.php');

$errors = [];
$messages = [];
$recipe = [
    'title' => '',
    'description' => '',
    'ingredients' => '',
    'instructions' => '',
    'category_id' => '',
    'image' => '',
];

$categories = getCategories($pdo);

if (isset($_POST['saveRecipe'])) {
    $fileName = null;

    // Si un fichier a été envoyé
    if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {

        // la méthode getimagessize va retourner false si le fichier n'est pas une image
        $checkImage = getimagesize($_FILES['file']['tmp_name']);
        if ($checkImage !== false) {

            // Si c'est une image on traite
            $fileName = uniqid() . '-' . slugify($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], _RECIPES_IMG_PATH_ . $fileName);
        } else {

            // Sinon on affiche un message d'erreur
            $errors[] = 'Le fichier doit être une image';
        }
    }

    if (!$errors) {
        $res = saveRecipe($pdo, $_POST['category'], $_POST['title'], $_POST['description'], $_POST['ingredients'], $_POST['instructions'], $fileName);

        if ($res) {
            $messages[] = 'La recette a bien été sauvegardée';
        } else {
            $errors[] = 'La recette n\'a pas été sauvegardée';
        }
    }
    $recipe = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'ingredients' => $_POST['ingredients'],
        'instructions' => $_POST['instructions'],
        'category_id' => $_POST['category'],
    ];

    if ($res === true) {
        $_SESSION['success_message'] = 'La recette a été sauvegarder';
        header('Location: gestion_recette.php');
        exit;
    } else {
        $errors[] = 'Un problème est survenu';
    };
}

?>

<h1>Ajouter une recette</h1>

<?php foreach ($messages as $message) { ?>
    <div class="alert alert-success">
        <?= $message; ?>
    </div>
<?php } ?>

<?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger">
        <?= $error; ?>
    </div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Titre</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $recipe['title']; ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" cols="30" rows="5"><?= $recipe['description']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="ingredients" class="form-label">Ingrédients</label>
        <textarea class="form-control" id="ingredients" name="ingredients" cols="30" rows="5"><?= $recipe['ingredients']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="instructions" class="form-label">Instructions</label>
        <textarea class="form-control" id="instructions" name="instructions" cols="30" rows="5"><?= $recipe['instructions']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Catégorie</label>
        <select class="form-select" id="category" name="category">

            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category['id']; ?>" <?php if ($recipe['category_id'] == $category['id']) {
                                                            echo 'selected="selected"';
                                                        } ?>><?= $category['name']; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label">Image</label>
        <input type="file" id="file" name="file" value="<?= $recipe['image']; ?>">
    </div>
    <input type="submit" value="Enregistrer" name="saveRecipe" class="btn btn-primary">
</form>

<?php
require_once('templates/footer.php');
?>