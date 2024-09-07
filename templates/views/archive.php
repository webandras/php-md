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
require $root_dir.'/templates/partials/header.php'; ?>

<main class="container">
    <section>
        <h1>All writings</h1>

        <?php
        $year_month_groups = [];
        foreach ($posts as $post) {
            $post_date           = new \DateTime($post['date'], new \DateTimeZone('Europe/Budapest'));
            $year_month_groups[] = $post_date->format('M Y');
        }
        $year_month_groups = array_unique($year_month_groups);
        ?>
        <ul>
            <?php
            foreach ($year_month_groups as $year_month) { ?>
            <li>
                    <div><?= $year_month ?></div>
                    <ul>
                        <?php
                        foreach ($posts as $post) {
                            $post_date = new \DateTime($post['date'], new \DateTimeZone(DEFAULT_TIMEZONE));
                            if ($post_date->format('M Y') === $year_month) { ?>
                                <li>
                                    <h3>
                                        <a href="<?= $post['slug'] ?>"><?= $post['title'] ?></a>
                                    </h3>
                                </li>
                                <?php
                            } ?>
                            <?php
                        } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </section>
</main>

<?php
require $root_dir.'/templates/partials/footer.php'; ?>

<script src="<?= BASE_URL.'assets/js/main.js' ?>"></script>

</body>
</html>

