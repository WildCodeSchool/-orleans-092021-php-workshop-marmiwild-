<?php
require __DIR__.'/../src/controllers/recipe-controller.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/' === $urlPath) {
    browseRecipes();
} elseif('/ajouter-recette' === $urlPath) {
    addRecipe();
}  elseif('/detail-recette' === $urlPath && isset($_GET['id'])) {
    showRecipe($_GET['id']);
} else {
    echo 'page non trouvée';
    header('HTTP/1.1 404 Not Found');
}