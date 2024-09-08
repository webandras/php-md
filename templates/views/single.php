<!DOCTYPE html>
<html lang="<?= $language_code ?>">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link href="<?= BASE_URL.'assets/css/trongate.css' ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= BASE_URL.'assets/css/main.css' ?>" rel="stylesheet" type="text/css"/>

    <title><?= $frontmatter['title'] ?></title>

    <?php
    require $root_dir.'/templates/partials/meta.php';
    ?>

    <script type="text/javascript">
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="single">

<?php
require $root_dir.'/templates/partials/header.php'; ?>

<main class="container">
    <?php
    require $root_dir.'/templates/partials/breadcrumb.php'; ?>
    <article>
        <?php
        require $root_dir.'/templates/partials/post-header.php'; ?>

        <?= $content ?>

        <footer></footer>
    </article>
    <br>
    <br>
</main>

<?php
require $root_dir.'/templates/partials/footer.php'; ?>

<script src="<?= BASE_URL.'assets/js/main.js' ?>"></script>

</body>
</html>

