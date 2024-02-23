<?php
require_once('lib/pdo.php');
require_once('lib/recipe.php');

$tri = isset($_GET['tri']) ? htmlspecialchars($_GET['tri'], ENT_QUOTES, 'UTF-8') : 'default';

$sql = "SELECT * FROM recipes WHERE 1=1";

switch ($tri) {
    case 'entree':
        $sql .= " AND category_id = 1 ORDER BY id DESC";
        break;
    case 'plat':
        $sql .= " AND category_id = 2 ORDER BY id DESC";
        break;
    case 'dessert':
        $sql .= " AND category_id = 3 ORDER BY id DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($recipes);
