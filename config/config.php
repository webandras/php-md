<?php

// The main config file
if ($env === 'dev') {
    define('BASE_URL', 'http://localhost/phpmd_blog/public/');
} else {
    define('BASE_URL', 'https://phpmd.netlify.app/');
}

define('DEFAULT_DATE_FORMAT', 'Y-m-d H:i');
define('DEFAULT_TIMEZONE', 'Europe/Budapest');
define('DEFAULT_LANGUAGE', 'en-gb');
define('LANGUAGES', array(
    'en-gb' => 'English',
    'hu-hu' => 'Magyar',
    'lt-lt' => 'Lietuvių',
));
