<?php

namespace DevIpsum\Handlers\API;

use DateTime;

use DevIpsum\Cache;
use DevIpsum\Config;
use DevIpsum\DevIpsum;
use DevIpsum\Handler;
use DevIpsum\Database;

class User extends Handler {

	static public $profiles = [
		'both' => 7,
		'male' => 35,
		'female' => 41
	];

	public function __construct($method, $resource, $params, $format) {
		parent::__construct($method, $resource, $params, $format);
		$this->paramList = ['n'];
	}

	public function handle() {
		if (!parent::handle()) {
			return false;
		}

		// number of users

		$n = (isset($this->params['n']) ? $this->params['n'] : 1);
		if ((int) $n !== $n || $n > 100 || $n < 1) {
			$this->response->rangeNotSatisfiable('Number of users must be an integer between 1 and 100');
			return false;
		}

		// names

		$names = [
			'first' => Cache::get('names', ['type' => 'first']),
			'last' => Cache::get('names', ['type' => 'last'])
		];

		if (!$names['first']) {
			$names['first'] = Database::read('names', 'type = :type', [':type' => 'first']);
			Cache::set('names', ['type' => 'first'], $names['first'], Config::SHORT_CACHE);
		}

		if (!$names['last']) {
			$names['last'] = Database::read('names',  'type = :type', [':type' => 'last']);
			Cache::set('names', ['type' => 'last'], $names['last'], Config::SHORT_CACHE);
		}

		$maxFirst = count($names['first']) - 1;
		$maxLast = count($names['last']) - 1;
		$users = [];

		// dates

		$now = new DateTime('now', DevIpsum::$dtz);
		$now = $now->getTimestamp();

		$daysInYear = 60 * 60 * 24 * 365.2425;

		// emails

		$emailDomains = Cache::get('domains', ['type' => 'email']);
		if (!$emailDomains) {
			$emailDomains = Database::read('domains', 'type = :type', [':type' => 'email']);
			Cache::set('domains', ['type' => 'email'], $emailDomains, Config::SHORT_CACHE);
		}

		$maxDomain = count($emailDomains) - 1;

		// cities
		$locations = Cache::get('locations', []);

		if (!$locations) {
			$locations = Database::fetchAll('SELECT `cities`.`name` city, `states`.`name` state, `streets`.`name` street FROM `cities`, `states`, `streets` WHERE `cities`.`state` = `states`.`id`;');
			Cache::set('locations', [], $locations, Config::SHORT_CACHE);
		}

		$maxLocation = count($locations) - 1;

		for ($i = 0; $i < $n; ++$i) {
			// names
			$first = $names['first'][mt_rand(0, $maxFirst)];
			$last = $names['last'][mt_rand(0, $maxLast)];
			$short = strtolower($first['name']{0} . $last['name']);

			// gender
			$gender = $first['gender'];

			// dates
			$ts = mt_rand(-631151999, 631152000); // 1950 to 1990
			$date = new DateTime('now', DevIpsum::$dtz);
			$date->setTimestamp($ts);
			$age = (int) (($now - $ts) / ($daysInYear));

			// emails
			$emailDomain = $emailDomains[mt_rand(0, $maxDomain)]['name'];

			// address
			$location = $locations[mt_rand(0, $maxLocation)];
			$city = $location['city'];
			$state = $location['state'];
			$street = mt_rand(100, 9999) . ' ' . $location['street'];

			// profile

			if ($gender === 'male') {
				$profile = mt_rand(1, self::$profiles['both'] + self::$profiles['male']);
			} else if ($gender === 'female') {
				$profile = mt_rand(1, self::$profiles['both'] + self::$profiles['male']);
			}

			if ($profile > self::$profiles['both']) {
				$profile = $gender . '-' . ($profile - self::$profiles['both']) . '.png';
			} else {
				$profile = 'both-' . $profile . '.png';
			}

			$profile = 'http://' . Config::IMG_HOST . '/profile/' . $profile;

			$users[] = [
				'name' => [
					'first' => $first['name'],
					'last' => $last['name'],
					'full' => $first['name'] . ' ' . $last['name']
				],
				'gender' => $gender,
				'birth' => [
					'date' => $date->format('c'),
					'age' => $age,
					'ts' => $ts
				],
				'address' => [
					'street' => $street,
					'city' => $city,
					'state' => $state,
					'country' => 'USA',
					'zip' => mt_rand(12345, 98765)
				],
				'contact' => [
					'phone' => '(' . mt_rand(111, 999) . ') ' . mt_rand(111, 999) . '-' . mt_rand(1111, 9999),
					'email' => $short . '@' . $emailDomain,
					'social' => [
						'profile' => $profile,
						'google' => 'http://plus.google.com/+' . $short,
						'facebook' => 'http://www.facebook.com/' . $short,
						'twitter' => 'http://twitter.com/' . $short
					],
					'website' => 'http://www.' . $short . '.com/'
				]
			];
		}

		$this->response->setTTL(Config::MICRO_CACHE);
		$this->response->users = $users;

		return true;
	}
}
