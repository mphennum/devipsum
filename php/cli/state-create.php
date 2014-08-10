#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\State;

require __DIR__ . '/../bootstrap.php';

$options = getopt('n:', ['help']);

if (isset($options['help'])) {
	CLI::message('Create state:');
	CLI::message('usage: ', 'state-create.php [OPTIONS]');
	CLI::message('-n     ', 'name or comma delimited list of names');
	exit(0);
}

CLI::title('Create state');

if (!isset($options['n'])) {
	CLI::error('Missing name');
}

$names = explode(',', $options['n']);
for ($i = 0, $n = count($names); $i < $n; ++$i) {
	if (trim($names[$i]) === '') {
		CLI::warning('Skipping blank name in position ' . $i);
		continue;
	}

	$state = new State();
	$state->name = trim($names[$i]);

	if ($state->exactExists()) {
		CLI::warning('Exact name exists for: ' . $state->name);
		continue;
	}

	if (!$state->create()) {
		CLI::warning('Failed to create state. Check that all fields are valid');
		continue;
	}

	CLI::message($state->name, ' has been created.');
}
