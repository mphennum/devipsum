#!/usr/bin/php
<?php

namespace DevIpsum;

use DevIpsum\Database\Word;

require __DIR__ . '/../bootstrap.php';

$options = getopt('w:l:', ['help']);

if (isset($options['help'])) {
	CLI::message('Create word:');
	CLI::message('usage: ', 'word-create.php [OPTIONS]');
	CLI::message('-w     ', 'word or comma delimited list of words');
	CLI::message('-l     ', 'language (' . implode(', ', Word::$languages) . ')');
	exit(0);
}

CLI::title('Create word');

if (!isset($options['w'])) {
	CLI::error('Missing word');
}

if (!isset($options['l'])) {
	CLI::error('Missing language');
}

$language = trim($options['l']);
$words = explode(',', $options['w']);
for ($i = 0, $n = count($words); $i < $n; ++$i) {
	if (trim($words[$i]) === '') {
		CLI::warning('Skipping blank word in position ' . $i);
		continue;
	}

	$word = new Word();
	$word->word = strtolower(trim($words[$i]));
	$word->language = $language;

	if ($word->exactExists()) {
		CLI::warning('Exact word, language exists for: ' . $word->word . ', ' . $word->language);
		continue;
	}

	if (!$word->create()) {
		CLI::warning('Failed to create word. Check that all fields are valid');
		continue;
	}

	CLI::message($word->word, ' has been created.');
}
