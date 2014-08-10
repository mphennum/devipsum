<?php

namespace DevIpsum;

require __DIR__ . '/Config.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/DevIpsum.php';
require __DIR__ . '/Handler.php';
require __DIR__ . '/Response.php';

require __DIR__ . '/handlers/api/User.php';
require __DIR__ . '/handlers/api/Text.php';
require __DIR__ . '/handlers/www/Home.php';

require __DIR__ . '/database/Row.php';
require __DIR__ . '/database/Name.php';

if (PHP_SAPI === 'cli') {
	require __DIR__ . '/CLI.php';
}

DevIpsum::init();
