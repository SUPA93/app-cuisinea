<?php
require_once('templates/header.php');
require_once('lib/category.php');
$categories = getCategories($pdo);

try {
    $tri = isset($_GET['tri']) ? htmlspecialchars($_GET['tri'], ENT_QUOTES, 'UTF-8') : null;

    if ($tri === "default") {
        $recipes = getRecipes($pdo);
    } elseif ($tri === "entree") {
        $recipes = getRecipesByCategory($pdo, 1);
    } elseif ($tri === "plat") {
        $recipes = getRecipesByCategory($pdo, 2);
    } elseif ($tri === "dessert") {
        $recipes = getRecipesByCategory($pdo, 3);
    } else {
        $recipes = getRecipes($pdo);
    }
} catch (PDOException $e) {
    echo 'Erreur SQL : ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '<br/>';
    die();
}

?>
<!-- Main start -->
<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <h1>Liste des recettes</h1>

    <!-- Filtre par catégorie -->
    <form id="triForm" method="GET" action="tri_recipes.php">
        <label for="tri">Filtrer par catégorie:</label>
        <select id="tri" name="tri">
            <option value="default" <?= $tri === "default" ? "selected" : "" ?>> Toutes les catégories</option>
            <option value="entree" <?= $tri === "entree" ? "selected" : "" ?>>Entrées</option>
            <option value="plat" <?= $tri === "plat" ? "selected" : "" ?>>Plats</option>
            <option value="dessert" <?= $tri === "dessert" ? "selected" : "" ?>>Desserts</option>
        </select>
    </form>
    <div class="row">

        <!-- Affichage des recettes -->
        <ul id="gridContainer" class="grid-container">
        </ul>
    </div>
</div>

<script src="assets/js/tri_recipes.js"></script>

<!-- Main end -->
<?php
require_once('templates/footer.php');
?>