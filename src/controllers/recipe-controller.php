<?php

require __DIR__ . '/../models/recipe-model.php';
require __DIR__ . '/../validation.php';

function browseRecipes(): void
{
    $recipes = getAllRecipes();

    // Generate the web page
    require __DIR__ . '/../views/index.php';
}

function addRecipe(): void
{
    // traiter ma requete en POST
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recipe = array_map('trim', $_POST);
        $errors = validateRecipe($recipe);

        if (empty($errors)) {
            $lastId = saveRecipe($recipe);
            header('Location: show.php?id=' . $lastId);
        }
    }

    // affichage
    require __DIR__ . '/../views/add.php';
}

function showRecipe(int $id): void
{
    $id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
    if (false === $id || null === $id) {
        header("Location: /");
        exit("Wrong input parameter");
    }

    $recipe = getRecipeById($id);

    // Database result check
    if (!isset($recipe['title']) || !isset($recipe['description'])) {
        header("Location: /");
        exit("Recipe not found");
    }

    // Generate the web page
    require __DIR__ . '/../views/show.php';
}
