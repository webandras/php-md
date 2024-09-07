<?php

$description = $pageName !== 'post' ? WEBSITE_DESCRIPTION : $frontmatter['excerpt'];
$title       = $pageName !== 'post' ? WEBSITE_NAME : $frontmatter['title'];
$url         = $pageName !== 'post' ? (BASE_URL.$pageName.'.html') : $frontmatter['slug'];
$image       = $pageName !== 'post' ? (BASE_URL.'assets/images/static.jpg') : (BASE_URL.'assets/images/'.$frontmatter['cover_image'])

?>

    <!-- Metas for social media-->
    <meta name="description" content="<?= $description ?>"/>
    <meta property="og:title" content="<?= $title ?>"/>
    <meta property="og:url" content="<?= $url ?>"/>
    <meta property="og:site_name" content="<?= WEBSITE_NAME ?>"/>
    <meta property="og:description" content="<?= $description ?>"/>
    <meta property="og:image" content="<?= $image ?>"/>
    <meta property="og:type" content="website"/>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="<?= WEBSITE_NAME ?>"/>
    <meta name="twitter:creator" content="<?= AUTHOR ?>"/>
    <meta name="twitter:title" content="<?= $title ?>"/>
    <meta name="twitter:description" content="<?= $description ?>"/>
    <meta name="twitter:url" content="<?= $url ?>"/>
    <meta name="twitter:image" content="<?= $image ?>"/>

    <link rel="canonical" href="<?= $url ?>"/>
