<?php

namespace DevIpsum\Database;

class Domain extends Row {

	static public $types = ['email'];

	public function __construct() {
		parent::__construct('domains');
		$this->fields['name'] = null;
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

		return true;
	}
}
