<?php

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/engine/PHPMD.php';

$phpmd = new PHPMD();
$posts = $phpmd->generatePosts(true);

var_dump($posts);

$phpmd->generatePosts();

exit;
