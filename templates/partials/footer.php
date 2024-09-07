<footer class="footer">
    <a class="footer--logo" href="<?= BASE_URL ?>">
      <img src="<?= BASE_URL.'assets/images/php-md-logo.png' ?>" alt="<?= OUR_NAME ?>" style="height: 50px;" />
    </a>

    <p><?= WEBSITE_DESCRIPTION ?></p>
    <ul class="footer--nav">
      <li>
        <a href="<?= BASE_URL ?>" <?php echo $page_name === 'index' ? 'aria-current="page"' : '' ?>>Home</a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>archive.html" <?php echo $page_name === 'archive' ? 'aria-current="page"' : '' ?>>Archive</a>
      </li>
    </ul>
    <aside class="footer--copyright">© <?= date('Y') ?> - <a href="<?= GITHUB ?>" class="hover:underline"><?= AUTHOR ?></a>. MIT license.</aside>
</footer>
