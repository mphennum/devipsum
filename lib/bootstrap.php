<?php

namespace DevIpsum;

require __DIR__ . '/../conf/Config.php';

require __DIR__ . '/Cache.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/DevIpsum.php';
require __DIR__ . '/Handler.php';
require __DIR__ . '/Response.php';

require __DIR__ . '/handlers/api/User.php';
require __DIR__ . '/handlers/api/Text.php';
require __DIR__ . '/handlers/www/Home.php';

require __DIR__ . '/database/Row.php';
require __DIR__ . '/database/City.php';
require __DIR__ . '/database/Domain.php';
require __DIR__ . '/database/Name.php';
require __DIR__ . '/database/Request.php';
require __DIR__ . '/database/State.php';
require __DIR__ . '/database/Street.php';
require __DIR__ . '/database/Word.php';

if (PHP_SAPI === 'cli') {
	require __DIR__ . '/CLI.php';
}

DevIpsum::init();
