<?php

namespace DevIpsum\Database;

use DevIpsum\Database;

class State extends Row {

	public function __construct() {
		parent::__construct('states');
		$this->fields['name'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['name'])) {
			return false;
		}

		return true;
	}

	// crud

	public function readOneName($name) {
		$row = Database::readOne($this->table, 'name = :name', [':name' => $name]);
		if ($row === null) {
			return false;
		}

		$this->fields = $row;
		return true;
	}
}
