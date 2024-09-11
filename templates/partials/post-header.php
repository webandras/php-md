    <header class="post-header">
        <h1><?= $frontmatter['title'] ?></h1>

        <img class="cover" src="<?= BASE_URL.$frontmatter['cover_image'] ?>" alt="<?= $frontmatter['title'] ?>">
        <p class="meta"><?= sprintf($posted_by_text, $frontmatter['author'], '<time>'.$frontmatter['date'].'</time>') ?></p>
        <hr>

        <p><b><?= $frontmatter['excerpt'] ?></b></p>
    </header>