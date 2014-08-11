<?php

namespace DevIpsum\Database;

class Street extends Row {

	public function __construct() {
		parent::__construct('streets');
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
