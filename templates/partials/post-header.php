    <header>
        <h1><?= $frontmatter['title'] ?></h1>

        <img class="cover" src="<?= BASE_URL.$frontmatter['cover_image'] ?>" alt="<?= $frontmatter['title'] ?>">
        <p class="meta">Posted by: <?= $frontmatter['author'] ?>, at <time><?= $frontmatter['date'] ?></time></p>
        <hr>

        <p>
            <b><?= $frontmatter['excerpt'] ?></b>
        <p>
        <br>
    </header>