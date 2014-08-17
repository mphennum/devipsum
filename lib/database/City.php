<?php

namespace DevIpsum\Database;

use DevIpsum\Database;

class City extends Row {

	public function __construct() {
		parent::__construct('cities');
		$this->fields['state'] = null;
		$this->fields['name'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['state'])) {
			return false;
		}

		if (!isset($this->fields['name'])) {
			return false;
		}

		return true;
	}

	public function readOneNameState($name, $state) {
		$row = Database::readOne($this->table, 'name = :name AND state = :state', [':name' => $name, ':state' => $state]);
		if ($row === null) {
			return false;
		}

		$this->fields = $row;
		return true;
	}
}
