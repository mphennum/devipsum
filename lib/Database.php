<?php

namespace DevIpsum;

use PDO;

abstract class Database {

	static private $pdo;

	// init

	static public function init() {
		self::$pdo = new PDO('mysql:dbname=' . Config::DB_NAME . ';host=' . Config::DB_HOST, Config::DB_USER, Config::DB_PASS);
	}

	// crud

	static public function create($table, $params) {
		$fields = '';
		$values = '';
		$pdovars = [];
		foreach ($params as $key => $value) {
			$fields .= '`' . $key . '`,';
			$values .= ':' . $key . ',';
			$pdovars[':' . $key] = $value;
		}

		$fields = substr($fields, 0, -1);
		$values = substr($values, 0, -1);

		$sql = 'INSERT INTO `' . $table . '` (' . $fields . ') VALUES (' . $values . ');';
		$statement = self::$pdo->prepare($sql);
		return $statement->execute($pdovars);
	}

	static public function read($table, $where = null, $pdovars = [], $limit = 100) {
		$sql = 'SELECT * FROM `' . $table . '`' . ($where === null ? '' : ' WHERE ' . $where) . ' LIMIT ' . (int) $limit . ';';
		return self::fetchAll($sql, $pdovars);
	}

	static public function readOne($table, $where = null, $pdovars = []) {
		$rows = self::read($table, $where, $pdovars, 1);
		return (count($rows) === 0 ? null : $rows[0]);
	}

	// nothing needs to be updated yet
	static public function update() {
		return false;
	}

	// nothing should ever be deleted
	static public function delete() {
		return false;
	}

	static public function count($table, $where = null, $pdovars = []) {
		$sql = 'SELECT count(*) FROM `' . $table . '`' . ($where === null ? '' : ' WHERE ' . $where) . ';';
		$row = self::fetch($sql, $pdovars);
		return ($row === null ? null : $row['count(*)']);
	}

	// pdo

	static public function execute($sql, $pdovars = []) {
		$statement = self::$pdo->prepare($sql);
		$statement->execute($pdovars);
		return $statement;
	}

	static public function fetch($sql, $pdovars = []) {
		$statement = self::execute($sql, $pdovars);

		if ($statement->rowCount() === 0) {
			return null;
		}

		$row = $statement->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	static public function fetchAll($sql, $pdovars = []) {
		$statement = self::execute($sql, $pdovars);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	// rand IDs

	static public function randIntUUID($table) {
		$row = true;
		while ($row !== null) {
			$id = self::randIntID();
			$row = self::readOne($table, '`id` = :id', [':id' => $id]);
		}

		return $id;
	}

	static public function randIntID() {
		return mt_rand(Config::ID_MIN, Config::ID_MAX);
	}

	static public function randUUID($table) {
		$max = strlen(Config::$uuidChars) - 1;

		$row = true;
		while ($row !== null) {
			$id = '';
			for ($i = 0; $i < Config::UUID_LEN; ++$i) {
				$id .= Config::$uuidChars{mt_rand(0, $max)};
			}

			$row = self::readOne($table, '`id` = :id', [':id' => $id]);
		}

		return $id;
	}
}
