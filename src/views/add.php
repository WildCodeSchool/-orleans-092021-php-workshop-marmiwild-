<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
</head>

<body>
    <h1>Add a Recipe</h1>

    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
    <form action="" method="POST" novalidate>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?= $recipe['title'] ?? '' ?>">

        <label for="description">Description</label>
        <textarea name="description" id="description" cols="30" rows="10"><?= $recipe['description'] ?? '' ?></textarea>

        <button>Add recipe</button>
    </form>

    <a href="index.php">Back</a>

</body>

</html>