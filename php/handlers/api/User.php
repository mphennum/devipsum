<?php

namespace DevIpsum\Handlers\API;

use DevIpsum\Handler;
use DevIpsum\Database;

class User extends Handler {

	public function __construct($method, $resource, $params, $format) {
		parent::__construct($method, $resource, $params, $format);
	}

	public function handle() {
		parent::handle();

		$names = [
			'first' => Database::read('names', 'type = :type', [':type' => 'first']),
			'last' => Database::read('names',  'type = :type', [':type' => 'last'])
		];

		$maxFirst = count($names['first']) - 1;
		$maxLast = count($names['last']) - 1;
		$users = [];

		$n = (isset($this->params['n']) ? $this->params['n'] : 1);

		for ($i = 0; $i < $n; ++$i) {
			$first = $names['first'][mt_rand(0, $maxFirst)];
			$last = $names['last'][mt_rand(0, $maxLast)];

			$users[] = [
				'name' => [
					'first' => $first['name'],
					'last' => $last['name']
				],
				'gender' => $first['gender'],
				'born' => '',
				'age' => '',
				'address' => [
					'street' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zip' => ''
				],
				'contact' => [
					'phone' => '',
					'email' => '',
					'social' => '',
					'website' => ''
				],
				'email' => '',
				'phone' => '',
				'job' => [
					'title' => '',
					'salary' => ''
				]
			];
		}

		$this->response->users = $users;
	}
}
