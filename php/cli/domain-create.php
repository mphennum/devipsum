#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\Domain;

require __DIR__ . '/../bootstrap.php';

$options = getopt('n:t:', ['help']);

if (isset($options['help'])) {
	CLI::message('Create domain:');
	CLI::message('usage: ', 'domain-create.php [OPTIONS]');
	CLI::message('-n     ', 'name or comma delimited list of names');
	CLI::message('-t     ', 'type of domain (' . implode(', ', Domain::$types) . ')');
	exit(0);
}

CLI::title('Create domain');

if (!isset($options['n'])) {
	CLI::error('Missing name');
}

if (!isset($options['t'])) {
	CLI::error('Missing type');
}

$type = trim($options['t']);
$names = explode(',', $options['n']);
for ($i = 0, $n = count($names); $i < $n; ++$i) {
	if (trim($names[$i]) === '') {
		CLI::warning('Skipping blank name in position ' . $i);
		continue;
	}

	$domain = new Domain();
	$domain->name = trim($names[$i]);
	$domain->type = $type;

	if ($domain->exactExists()) {
		CLI::warning('Exact name, type exists for: ' . $domain->name . ', ' . $domain->type);
		continue;
	}

	if (!$domain->create()) {
		CLI::warning('Failed to create domain. Check that all fields are valid');
		continue;
	}

	CLI::message($domain->name, ' has been created.');
}
