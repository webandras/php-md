<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link href="./../assets/css/trongate.css" rel="stylesheet" type="text/css"/>
    <link href="./../assets/css/main.css" rel="stylesheet" type="text/css"/>

    <title><?= $data['frontmatter']['title'] ?></title>

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
require dirname(__DIR__).'/partials/header.php'; ?>

<main class="container">
    <?php require dirname(__DIR__).'/partials/breadcrumb.php'; ?>
    <article>
        <?php
        require dirname(__DIR__).'/partials/post-header.php'; ?>

        <?= $data['content'] ?>

        <footer></footer>
    </article>
</main>

<?php
require dirname(__DIR__).'/partials/footer.php'; ?>

<script src="./../assets/js/main.js"></script>

</body>
</html>

