<!DOCTYPE html>
<html lang="<?= DEFAULT_LANGUAGE ?>">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link href="<?= BASE_URL.'assets/css/trongate.css' ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= BASE_URL.'assets/css/main.css' ?>" rel="stylesheet" type="text/css"/>

    <title><?= OUR_NAME ?></title>

    <script type="text/javascript">
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body>

<?php
require dirname(__DIR__).'/partials/header.php'; ?>

<main class="container">

    <?php
    require dirname(__DIR__).'/partials/introduction.php'; ?>

    <section>
        <h2>Newest writings</h2>
        <ol class="post-list">
            <?php
            foreach ($posts as $post) { ?>
                <li>
                    <time class="small"><?= $post['date'] ?></time>
                    <h3>
                        <a href="<?= BASE_URL.$post['slug'] ?>"><?= htmlentities($post['title']) ?></a>
                    </h3>
                    <p><?= $post['excerpt'] ?></p>
                </li>
                <?php
            } ?>
        </ol>
    </section>
</main>

<?php
require dirname(__DIR__).'/partials/footer.php'; ?>

<script src="<?= BASE_URL.'assets/js/main.js' ?>"></script>

</body>
</html>

