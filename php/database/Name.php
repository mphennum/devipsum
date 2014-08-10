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
		if ($this->fields['name'] === null) {
			return false;
		}

		if ($this->fields['type'] === null) {
			return false;
		}

		$valid = false;
		foreach (self::$types as $type) {
			if ($this->fields['type'] === $type) {
				$valid = true;
				break;
			}
		}

		if (!$valid) {
			return false;
		}

		$valid = false;
		foreach (self::$genders as $gender) {
			if ($this->fields['gender'] === $gender) {
				$valid = true;
				break;
			}
		}

		if (!$valid) {
			return false;
		}

		return true;
	}
}
