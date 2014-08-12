<?php

namespace DevIpsum\Database;

class Name extends Row {

	static public $genders = ['male', 'female', 'both'];
	static public $types = ['first', 'last'];

	public function __construct() {
		parent::__construct('names');
		$this->fields['name'] = null;
		$this->fields['gender'] = 'both';
		$this->fields['type'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['name'])) {
			return false;
		}

		if (!in_array($this->fields['type'], self::$types)) {
			return false;
		}

		if (!in_array($this->fields['gender'], self::$genders)) {
			return false;
		}

		return true;
	}
}
