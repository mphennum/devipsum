#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\City;
use DevIpsum\Database\State;

require __DIR__ . '/../lib/bootstrap.php';

$options = getopt('n:s:', ['help']);

if (isset($options['help'])) {
	CLI::message('Create city:');
	CLI::message('usage: ', 'city-create.php [OPTIONS]');
	CLI::message('-n     ', 'name or comma delimited list of names');
	CLI::message('-s     ', 'state name');
	exit(0);
}

CLI::title('Create city');

if (!isset($options['n'])) {
	CLI::error('Missing name');
}

if (!isset($options['s'])) {
	CLI::error('Missing state');
}

$state = new State();
if (!$state->readOneName(trim($options['s']))) {
	CLI::error('Cannot find state: ' . trim($options['s']));
}

$names = explode(',', $options['n']);
for ($i = 0, $n = count($names); $i < $n; ++$i) {
	if (trim($names[$i]) === '') {
		CLI::warning('Skipping blank name in position ' . $i);
		continue;
	}

	$city = new City();
	$city->name = trim($names[$i]);
	$city->state = $state->id;

	if ($city->exactExists()) {
		CLI::warning('Exact name, state exists for: ' . $city->name . ', ' . $state->name);
		continue;
	}

	if (!$city->create()) {
		CLI::warning('Failed to create city. Check that all fields are valid');
		continue;
	}

	CLI::message($city->name, ' has been created.');
}
