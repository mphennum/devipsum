<?php

namespace DevIpsum\Handlers\API;

use DevIpsum\Cache;
use DevIpsum\Config;
use DevIpsum\Database;
use DevIpsum\Handler;

class Text extends Handler {

	public function __construct($method, $resource, $params, $format) {
		parent::__construct($method, $resource, $params, $format);
		$this->paramList = ['n'];
	}

	public function handle() {
		if (!parent::handle()) {
			return false;
		}

		// number of paragraphs

		$n = (isset($this->params['n']) ? $this->params['n'] : 1);
		if ((int) $n !== $n || $n > 10 || $n < 1) {
			$this->response->rangeNotSatisfiable('Number of paragraphs must be an integer between 1 and 10');
			return false;
		}

		// words

		$words = Cache::get('words');
		if (!$words) {
			$words = Database::read('words');
			Cache::set('words', [], $words, Config::SHORT_CACHE);
		}

		$maxWord = count($words) - 1;

		// text

		$text = [];
		for ($i = 0; $i < $n; ++$i) {
			$paragraph = '';
			for ($j = 0, $numSentences = mt_rand(1, 5); $j < $numSentences; ++$j) {
				$sentence = '';
				for ($k = 0, $numWords = mt_rand(3, 10); $k < $numWords; ++$k) {
					$word = $words[mt_rand(0, $maxWord)]['word'];

					if ($k === 0) {
						$word = ucwords($word);
					}

					$sentence .= $word . ' ';
				}

				$sentence = substr($sentence, 0, -1) . '.';
				$paragraph .= $sentence . ' ';
			}

			$paragraph = substr($paragraph, 0, -1);
			$text[] = $paragraph;
		}

		$this->response->setTTL(Config::MICRO_CACHE);
		$this->response->text = $text;
		return true;
	}
}
