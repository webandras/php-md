<footer class="footer">
    <a class="footer--logo" href="<?= BASE_URL ?>">
        <img src="<?= BASE_URL.'assets/images/php-md-logo.png' ?>" alt="<?= $our_name ?>" height="50px" width="95.83px"/>
    </a>

    <p><?= $website_description ?></p>
    <ul class="footer--nav">
        <li><a href="<?= BASE_URL.get_language_segment($language_code) ?>" <?php echo set_active_page_link($template_name) ?>><?= $home_text ?></a></li>
        <li><a href="<?= BASE_URL.get_language_segment($language_code) ?>archive" <?php echo set_active_page_link($template_name, 'archive') ?>><?= $archive_text ?></a>
        </li>
    </ul>
    <aside class="footer--copyright">© <?= date('Y') ?> - <a href="<?= $github ?>" class="hover:underline"><?= $author ?></a>. <?= $license_text ?></aside>
</footer>
