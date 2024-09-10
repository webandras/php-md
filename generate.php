<?php

$time_start = microtime(true);

// Get command line arguments (options)
$short_options  = '';
$long_options = ['env:'];
$options = getopt($short_options, $long_options);
extract($options);
settype($env, 'string');

// Require all files here
require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/config/translations.php';
require_once __DIR__.'/engine/helpers/helpers.php';
require_once __DIR__.'/engine/PHP_MD.php';

// Instantiate the site generator class
$phpmd = new PHP_MD();

foreach(LANGUAGES as $current_language_code => $current_language_name) {
    $posts = [];
    // Generate the posts, get posts list for the pages
    $posts = $phpmd->generate_posts($current_language_code, $translations[$current_language_code]);

    // Generate the pages
    $phpmd->generate_index_page($current_language_code, $translations[$current_language_code]);
    $phpmd->generate_archive_page($current_language_code, $translations[$current_language_code]);
    $phpmd->generate_404_page($current_language_code, $translations[$current_language_code]);
}

$time_end = microtime(true);
printf('[PHP-MD] SUCCESSFUL build in %f ms.', ($time_end - $time_start) * 1000);
exit;
