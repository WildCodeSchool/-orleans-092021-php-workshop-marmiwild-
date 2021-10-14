<?php

function validateRecipe(array $recipe): array
{
    if(empty($recipe['title'])) {
        $errors[] = 'Le titre est obligatoire';
    }

    $maxLength = 255;
    if(strlen($recipe['title'])> $maxLength) {
        $errors[] = 'Le titre doit faire moins de ' . $maxLength . ' caractères';
    }

    if(empty($recipe['description'])) {
        $errors[] = 'La description est obligatoire';
    }

    return $errors ?? [];
}