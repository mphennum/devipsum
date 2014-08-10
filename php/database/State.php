<?php

namespace DevIpsum\Database;

class State extends Row {

	public function __construct() {
		parent::__construct('states');
		$this->fields['name'] = null;
	}

	// fields

	public function hasValidFields() {
		if ($this->fields['name'] === null) {
			return false;
		}

		return true;
	}
}
