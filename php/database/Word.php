<?php

namespace DevIpsum\Database;

class Word extends Row {

	static public $languages = ['latin'];

	public function __construct() {
		parent::__construct('words');
		$this->fields['word'] = null;
		$this->fields['language'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['word'])) {
			return false;
		}

		if (!in_array($this->fields['language'], self::$languages)) {
			return false;
		}

		return true;
	}
}
