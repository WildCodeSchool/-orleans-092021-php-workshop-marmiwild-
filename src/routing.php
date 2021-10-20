<?php

require __DIR__.'/controllers/RecipeController.php';

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/' === $urlPath) {
    (new RecipeController())->browse();
} elseif ('/show' === $urlPath && isset($_GET['id'])) {
    $recipeController = new RecipeController();
    $recipeController->show($_GET['id']);
} elseif ('/add' === $urlPath) {
    $recipeController = new RecipeController();
    $recipeController->add();
} elseif ('/edit' === $urlPath && isset($_GET['id'])) {
    $recipeController = new RecipeController();
    $recipeController->edit($_GET['id']);
} elseif ('/delete' === $urlPath && isset($_GET['id'])) {
    $recipeController = new RecipeController();
    $recipeController->delete($_GET['id']);
}
else {
    header('HTTP/1.1 404 Not Found');
}
