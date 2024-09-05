<header>
    <h1><?= $data['frontmatter']['title'] ?></h1>

    <img class="cover" src="<?= BASE_URL.'public/assets/images/'.$data['frontmatter']['cover_image'] ?>"
         alt="<?= $data['frontmatter']['title'] ?>">
    <p class="meta">Posted by: <?= $data['frontmatter']['author'] ?>, at <time><?= $data['frontmatter']['date'] ?></time></p>
    <hr>

    <p>
        <b><?= $data['frontmatter']['excerpt'] ?></b>
    <p>
    <br>
</header>