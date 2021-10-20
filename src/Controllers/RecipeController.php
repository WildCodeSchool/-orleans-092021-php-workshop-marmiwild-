<?php

namespace App\Controllers;

use App\Models\RecipeModel;

class RecipeController
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/views');
        $this->twig = new \Twig\Environment(
            $loader,
            [
                'cache' => false,
            ]
        );
    }

    public function browse(): string
    {
        // Fetching all recipes
        $recipeModel = new RecipeModel();
        $recipes = $recipeModel->getAll();

        // Generate the web page
        return $this->twig->render('recipes/index.html.twig', ['recipes' => $recipes]);
    }

    public function show(int $id): string
    {
        // Input parameter validation (integer >0)
        $id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if (false === $id || null === $id) {
            header("Location: /");
            exit("Wrong input parameter");
        }

        // Fetching a recipe
        $recipeModel = new RecipeModel();
        $recipe = $recipeModel->getById($id);

        // Result check
        if (!isset($recipe['title']) || !isset($recipe['description'])) {
            header("Location: /");
            exit("Recipe not found");
        }

        // Generate the web page
        return $this->twig->render('recipes/show.html.twig', ['recipe' => $recipe]);
    }

    public function add(): void
    {
        $errors = [];

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $recipe = array_map('trim', $_POST);

            // Validate data
            $errors = $this->validate($recipe);

            // Save the recipe
            if (empty($errors)) {
                $recipeModel = new RecipeModel();
                $recipeModel->save($recipe);
                header('Location: /');
            }
        }

        // Generate the web page
        $editionMode = 'Add';
        require __DIR__ . '/../views/form.php';
    }

    public function edit(int $id): void
    {
        $errors = [];
        $recipeModel = new RecipeModel();
        $recipe = $recipeModel->getById($id);

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $recipe = array_map('trim', $_POST);
            // Validate data
            $errors = $this->validate($recipe);

            // Save the recipe
            if (empty($errors)) {
                $recipe['id'] = $id;
                $recipeModel->update($recipe);
                header('Location: /');
            }
        }

        // Generate the web page
        $editionMode = 'Update';
        require __DIR__ . '/../views/form.php';
    }

    private function validate(array $recipe): array
    {
        if (empty($recipe['title'])) {
            $errors[] = 'The title is required';
        }
        if (empty($recipe['description'])) {
            $errors[] = 'The description is required';
        }
        if (!empty($recipe['title']) && strlen($recipe['title']) > 255) {
            $errors[] = 'The title should be less than 255 characters';
        }

        return $errors ?? [];
    }

    public function delete(int $id)
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $recipeModel = new RecipeModel();
            $recipe = $recipeModel->remove($id);
            header('Location: /');
        }
    }
}
