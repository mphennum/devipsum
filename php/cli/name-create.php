#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\Name;

require __DIR__ . '/../bootstrap.php';

$options = getopt('n:t:mf', ['help']);

if (isset($options['help'])) {
	CLI::message('Create name:');
	CLI::message('usage: ', 'name-create.php [OPTIONS]');
	CLI::message('-n     ', 'name or comma delimited list of names');
	CLI::message('-t     ', 'type of name (' . implode(', ', Name::$types) . ')');
	CLI::message('-m     ', 'male');
	CLI::message('-f     ', 'female');
	exit(0);
}

CLI::title('Create name');

if (!isset($options['n'])) {
	CLI::error('Missing name');
}

if (!isset($options['t'])) {
	CLI::error('Missing type');
}

if (isset($options['m']) && !isset($options['f'])) {
	$gender = 'male';
} else if (isset($options['f']) && !isset($options['m'])) {
	$gender = 'female';
} else {
	$gender = 'both';
}

$type = trim($options['t']);
$names = explode(',', $options['n']);
for ($i = 0, $n = count($names); $i < $n; ++$i) {
	if (trim($names[$i]) === '') {
		CLI::warning('Skipping blank name in position ' . $i);
		continue;
	}

	$name = new Name();
	$name->name = trim($names[$i]);
	$name->type = $type;
	$name->gender = $gender;

	if ($name->exactExists()) {
		CLI::warning('Exact name, type, gender exists for: ' . $name->name . ', ' . $name->type . ', ' . $name->gender);
		continue;
	}

	if (!$name->create()) {
		CLI::warning('Failed to create name. Check that all fields are valid');
		continue;
	}

	CLI::message($name->name, ' has been created.');
}
