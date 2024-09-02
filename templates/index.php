<!DOCTYPE html>
<html lang="<%= site.lang %>">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <link href="./assets/css/trongate.css" rel="stylesheet" type="text/css"/>
    <link href="./assets/css/main.css" rel="stylesheet" type="text/css"/>

    <title>Newest posts</title>
</head>

<body>

<main class="container">
    <h1><?= OUR_NAME ?>'s Blog</h1>
    <hr>
    <ul>
        <?php
        foreach ($posts as $post) { ?>
            <li>
                <a href="<?= $post['slug'] ?>"><?= htmlentities($post['title']) ?></a>
            </li>
        <?php
        } ?>
    </ul>
</main>

</body>
</html>

