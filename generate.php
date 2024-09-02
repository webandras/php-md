<?php
$time_start = microtime(true);

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/config/site_owner.php';
require_once __DIR__.'/engine/PHPMD.php';

$phpmd = new PHPMD();
$posts = $phpmd->generatePosts();
$phpmd->generateIndexPage();

$time_end = microtime(true);
printf('[PHP-MD] SUCCESSFUL build in %f ms.', ($time_end - $time_start) * 1000);
exit;
