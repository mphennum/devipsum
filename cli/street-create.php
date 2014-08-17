#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\Street;

require __DIR__ . '/../lib/bootstrap.php';

$options = getopt('n:', ['help']);

if (isset($options['help'])) {
	CLI::message('Create street:');
	CLI::message('usage: ', 'street-create.php [OPTIONS]');
	CLI::message('-n     ', 'name or comma delimited list of names');
	exit(0);
}

CLI::title('Create street');

if (!isset($options['n'])) {
	CLI::error('Missing name');
}

$names = explode(',', $options['n']);
for ($i = 0, $n = count($names); $i < $n; ++$i) {
	if (trim($names[$i]) === '') {
		CLI::warning('Skipping blank name in position ' . $i);
		continue;
	}

	$street = new Street();
	$street->name = trim($names[$i]);

	if ($street->exactExists()) {
		CLI::warning('Exact name exists for: ' . $street->name);
		continue;
	}

	if (!$street->create()) {
		CLI::warning('Failed to create street. Check that all fields are valid');
		continue;
	}

	CLI::message($street->name, ' has been created.');
}
