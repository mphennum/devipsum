<?php

namespace DevIpsum\Database;

class Street extends Row {

	public function __construct() {
		parent::__construct('streets');
		$this->fields['name'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['name'])) {
			return false;
		}

		return true;
	}
}
