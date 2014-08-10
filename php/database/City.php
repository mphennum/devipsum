<?php

namespace DevIpsum\Database;

class City extends Row {

	public function __construct() {
		parent::__construct('cities');
		$this->fields['state'] = null;
		$this->fields['name'] = null;
	}

	// fields

	public function hasValidFields() {
		if ($this->fields['state'] === null) {
			return false;
		}

		if ($this->fields['name'] === null) {
			return false;
		}

		return true;
	}
}
