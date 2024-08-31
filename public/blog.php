<?php

$rootDir = dirname(__DIR__);

require $rootDir.'/vendor/autoload.php';
require_once $rootDir.'/config/config.php';
require_once $rootDir.'/config/site_owner.php';
require_once $rootDir.'/engine/PHPMD.php';

$phpmd = new PHPMD();
$posts = $phpmd->generatePosts(true);

ob_start();
require $rootDir.'/layouts/blog.php';
$post['content'] = ob_get_contents();
ob_end_flush();
