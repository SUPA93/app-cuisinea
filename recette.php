<?php
require_once('templates/header.php');
require_once('lib/tools.php');
require_once('lib/recipe.php');

// Fetch recipe ID from GET request
$id = (int)$_GET['id'];

// Function to get recipe details by ID
$recipe = getRecipeById($pdo, $id);

// If recipe exists, display it
if ($recipe) {

    // Convert ingredients and instructions to array
    $ingredients = linesToArray($recipe['ingredients']);
    $instructions = linesToArray($recipe['instructions']);
?>

    <!-- Display recipe details -->
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5 m-4">
        <div class="col-10 col-sm-8 col-lg-6">

            <!-- Recipe Image -->
            <img src="<?= getRecipeImage($recipe['image']); ?>" class="d-block mx-lg-auto img-fluid" alt="<?= $recipe['title']; ?>" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3"><?= $recipe['title']; ?></h1>
            <p class="lead"><?= $recipe['description']; ?></p>
        </div>
    </div>

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5 m-2">
        <h2>Ingrédients</h2>
        <ul class="list-group">
            <?php foreach ($ingredients as $key => $ingredient) { ?>
                <li class="list-group-item"><?= $ingredient; ?></li>
            <?php } ?>
        </ul>
    </div>

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5 m-2">
        <h2>Instructions</h2>
        <ol class="list-group list-group-numbered">
            <?php foreach ($instructions as $key => $instruction) { ?>
                <li class="list-group-item"><?= $instruction; ?></li>
            <?php } ?>
        </ol>
    </div>

    <!-- Reviews section -->
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5 m-2">
        <h2>Commentaires</h2>
        <div class="col-lg-6">
            <form action="comment.php" method="post">
                <div class="mb-3">
                    <label for="comment" class="form-label">Commentaire</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <input type="hidden" name="recipe_id" value="<?= $recipe['id']; ?>">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>

        <!-- Recipe errors -->
    <?php } else { ?>
        <div class="row text-center">
            <h1>Recette introuvable</h1>
        </div>
    <?php } ?>

    <?php
    require_once('templates/footer.php');
    ?>