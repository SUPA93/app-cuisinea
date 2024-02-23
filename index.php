<?php

require_once('templates/header.php');
require_once('lib/recipe.php');

$recipes = getRecipes($pdo, _HOME_RECIPES_LIMIT_);

?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <img src="assets/images/logo-cuisinea.jpg" class="d-block mx-lg-auto img-fluid m-4" alt="Logo Cuisinea" width="250" loading="lazy">
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Cuisinea - Recettes de cuisines</h1>
        <p class="lead p-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, quibusdam ea aperiam dignissimos soluta quae quam possimus saepe voluptates autem ipsum nulla sapiente illum cupiditate earum ullam omnis ipsa. Dignissimos, debitis quibusdam! Est facilis, nisi dolorem mollitia earum odit necessitatibus ea quisquam magni, sapiente, nihil pariatur velit? Porro, repellendus neque.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a id="seeRecipesBtn" href="recettes.php" class="btn btn-primary">Voir nos recettes</a>
        </div>
    </div>
</div>

<div class="row">

    <?php foreach ($recipes as $key => $recipe) {
        include('templates/recipe_partial.php');
    } ?>

</div>

<?php
require_once('templates/footer.php');
?>