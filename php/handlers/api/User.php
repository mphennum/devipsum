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

		// names

		$names = [
			'first' => Database::read('names', 'type = :type', [':type' => 'first']),
			'last' => Database::read('names',  'type = :type', [':type' => 'last'])
		];

		$maxFirst = count($names['first']) - 1;
		$maxLast = count($names['last']) - 1;
		$users = [];

		// dates

		$now = new DateTime('now', DevIpsum::$dtz);
		$now = $now->getTimestamp();

		$daysInYear = 60 * 60 * 24 * 365.2425;

		// emails

		$emailDomains = Database::read('domains', 'type = :type', [':type' => 'email']);
		$maxDomain = count($emailDomains) - 1;

		// cities
		$cities = Database::fetchAll('SELECT `cities`.`name` city, `states`.`name` state FROM `cities`, `states` WHERE `cities`.`state` = `states`.`id`;');
		$maxCity = count($cities) - 1;

		$n = (isset($this->params['n']) ? $this->params['n'] : 1);
		for ($i = 0; $i < $n; ++$i) {
			// names
			$first = $names['first'][mt_rand(0, $maxFirst)];
			$last = $names['last'][mt_rand(0, $maxLast)];
			$short = strtolower($first['name']{0} . $last['name']);

			// dates
			$ts = mt_rand(-631151999, 946684800); // 1950 to 2000
			$date = new DateTime('now', DevIpsum::$dtz);
			$date->setTimestamp($ts);
			$age = (int) (($now - $ts) / ($daysInYear));

			// emails
			$emailDomain = $emailDomains[mt_rand(0, $maxDomain)]['name'];

			// address
			$location = $cities[mt_rand(0, $maxCity)];
			$city = $location['city'];
			$state = $location['state'];

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
					'city' => $city,
					'state' => $state,
					'country' => '',
					'zip' => ''
				],
				'contact' => [
					'phone' => '',
					'email' => $short . '@' . $emailDomain,
					'social' => [
						'google' => 'http://plus.google.com/+' . $short,
						'facebook' => 'http://www.facebook.com/' . $short,
						'twitter' => 'http://twitter.com/' . $short
					],
					'website' => 'http://www.' . $short . '.com/'
				]
			];
		}

		$this->response->users = $users;
	}
}
