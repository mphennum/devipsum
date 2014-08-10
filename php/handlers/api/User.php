<?php

namespace DevIpsum\Handlers\API;

use DateTime;

use DevIpsum\DevIpsum;
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

		$now = new DateTime('now', DevIpsum::$dtz);
		$now = $now->getTimestamp();

		$daysInYear = 60 * 60 * 24 * 365.2425;

		$n = (isset($this->params['n']) ? $this->params['n'] : 1);
		for ($i = 0; $i < $n; ++$i) {
			$first = $names['first'][mt_rand(0, $maxFirst)];
			$last = $names['last'][mt_rand(0, $maxLast)];

			$ts = mt_rand(-631151999, 946684800); // 1950 to 2000
			$date = new DateTime('now', DevIpsum::$dtz);
			$date->setTimestamp($ts);
			$age = (int) (($now - $ts) / ($daysInYear));

			$users[] = [
				'name' => [
					'first' => $first['name'],
					'last' => $last['name'],
					'full' => $first['name'] . ' ' . $last['name']
				],
				'gender' => $first['gender'],
				'birth' => [
					'date' => $date->format('c'),
					'age' => $age,
					'ts' => $ts
				],
				'address' => [
					'street' => '',
					'city' => '',
					'state' => '',
					'country' => '',
					'zip' => ''
				],
				'contact' => [
					'phone' => '',
					'email' => strtolower($first['name']{0} . $last['name']) . '@gmail.com',
					'social' => [
						'google' => '',
						'facebook' => '',
						'twitter' => ''
					],
					'website' => ''
				]
			];
		}

		$this->response->users = $users;
	}
}
