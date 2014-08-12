<?php

namespace DevIpsum\Database;

class Image extends Row {

	static public $types = ['profile'];

	public function __construct() {
		parent::__construct('images');
		$this->fields['name'] = null;
		$this->fields['dir'] = null;
		$this->fields['file'] = null;
		$this->fields['width'] = null;
		$this->fields['height'] = null;
		$this->fields['type'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['dir'])) {
			return false;
		}

		if (!isset($this->fields['file'])) {
			return false;
		}

		if (!isset($this->fields['width'])) {
			return false;
		}

		if (!isset($this->fields['height'])) {
			return false;
		}

		if (!in_array($this->fields['type'], self::$types)) {
			return false;
		}

		return true;
	}
}
