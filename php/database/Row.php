<?php

namespace DevIpsum\Database;

use Exception;

use DevIpsum\Database;

abstract class Row {

	protected $table;
	protected $stringID;
	protected $fields;

	public function __construct($table, $stringID = false) {
		$this->table = $table;
		$this->stringID = $stringID;
		$this->fields = ['id' => null];
	}

	// fields

	abstract public function hasValidFields();

	public function __get($key) {
		if (!isset($this->fields[$key])) {
			return null;
		}

		return $this->fields[$key];
	}

	public function __set($key, $value) {
		if (!array_key_exists($key, $this->fields)) {
			throw new Exception('Trying to set unsupported field "' . $key . '" for table "' . $this->table . '"');
		}

		$this->fields[$key] = $value;
	}

	// crud

	public function create() {
		if (!$this->hasValidFields()) {
			return false;
		}

		if ($this->fields['id'] === null) {
			if ($this->stringID) {
				$this->fields['id'] = Database::randUUID($this->table);
			} else {
				$this->fields['id'] = Database::randIntUUID($this->table);
			}
		}

		return Database::create($this->table, $this->fields);
	}

	public function readOne($id) {
		$row = Database::readOne($this->table, 'id = :id', [':id' => $id]);
		if ($row === null) {
			return false;
		}

		$this->fields = $row;
		return true;
	}

	public function exactExists() {
		$where = '';
		$pdovars = [];
		foreach ($this->fields as $key => $value) {
			if ($key === 'id') {
				continue;
			}

			$where .= $key . ' = :' . $key . ' AND ';
			$pdovars[':' . $key] = $value;
		}

		$where = substr($where, 0, -5);

		return (Database::readOne($this->table, $where, $pdovars) !== null);
	}
}
