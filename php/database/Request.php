<?php

namespace DevIpsum\Database;

class Request extends Row {

	static public $actions = ['create', 'read', 'update', 'delete'];
	static public $views = ['error.html', 'home.html', 'json', 'xml'];

	public function __construct() {
		parent::__construct('requests', true);
		$this->fields['action'] = null;
		$this->fields['resource'] = null;
		$this->fields['params'] = null;
		$this->fields['format'] = null;
		$this->fields['view'] = null;
		$this->fields['status'] = null;
		$this->fields['ts'] = null;
	}

	// fields

	public function hasValidFields() {
		if (!isset($this->fields['resource'])) {
			return false;
		}

		if (!isset($this->fields['format'])) {
			return false;
		}

		if (!isset($this->fields['view'])) {
			return false;
		}

		if (!isset($this->fields['status'])) {
			return false;
		}

		if (!in_array($this->fields['action'], self::$actions)) {
			return false;
		}

		if (!in_array($this->fields['view'], self::$views)) {
			return false;
		}

		return true;
	}
}
