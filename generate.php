<?php

$time_start = microtime(true);

$short_options  = '';
$long_options = ['env:'];
$options = getopt($short_options, $long_options);
extract($options);
settype($env, 'string');

require __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/config/site_owner.php';
require_once __DIR__.'/engine/PHPMD.php';

$phpmd = new PHPMD();
$posts = $phpmd->generatePosts();
$phpmd->generateIndexPage();

$phpmd->generateArchivePage();

$time_end = microtime(true);
printf('[PHP-MD] SUCCESSFUL build in %f ms.', ($time_end - $time_start) * 1000);
exit;
