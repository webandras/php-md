<footer class="footer">
    <a class="footer--logo" href="<?= BASE_URL ?>">
      <img src="<?= BASE_URL.'assets/images/php-md-logo.png' ?>" alt="<?= $our_name ?>" height="50px" width="95.83px" />
    </a>

    <p><?= $website_description ?></p>
    <ul class="footer--nav">
      <li>
        <a href="<?= BASE_URL. ($language_code !== DEFAULT_LANGUAGE ? ($language_code.'/') : '') ?>" <?php echo $page_name === 'index' ? 'aria-current="page"' : '' ?>>Home</a>
      </li>
      <li>
        <a href="<?= BASE_URL. ($language_code !== DEFAULT_LANGUAGE ? ($language_code.'/') : '') ?>archive" <?php echo $page_name === 'archive' ? 'aria-current="page"' : '' ?>>Archive</a>
      </li>
    </ul>
    <aside class="footer--copyright">© <?= date('Y') ?> - <a href="<?= $github ?>" class="hover:underline"><?= $author ?></a>. MIT license.</aside>
</footer>
