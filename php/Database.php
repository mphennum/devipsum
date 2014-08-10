<?php

namespace DevIpsum;

use PDO;

abstract class Database {

	const UUID_LEN = 32;
	const ID_MIN = 0;
	const ID_MAX = 4294967295;

	static public $uuidChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';

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
		$statement = self::$pdo->prepare($sql);

		$statement->execute($pdovars);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	static public function readOne($table, $where = null, $pdovars = []) {
		$rows = self::read($table, $where, $pdovars, 1);
		return (count($rows) === 0 ? null : $rows[0]);
	}

	static public function update() {
		// do nothing
	}

	static public function delete() {
		// do nothing
	}

	static public function count($table, $where = null, $pdovars = []) {
		$sql = 'SELECT count(*) FROM `' . $table . '`' . ($where === null ? '' : ' WHERE ' . $where) . ';';
		$statement = self::$pdo->prepare($sql);
		$statement->execute($pdovars);

		if ($statement->rowCount() === 0) {
			return null;
		}

		$row = $statement->fetch(PDO::FETCH_NUM);
		return $row[0];
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
		return mt_rand(self::ID_MIN, self::ID_MAX);
	}

	static public function randUUID($table) {
		$max = strlen(self::$uuidChars) - 1;

		$row = true;
		while ($row !== null) {
			$id = '';
			for ($i = 0; $i < self::UUID_LEN; ++$i) {
				$id .= self::$uuidChars{mt_rand(0, $max)};
			}

			$row = self::readOne($table, '`id` = :id', [':id' => $id]);
		}

		return $id;
	}
}
