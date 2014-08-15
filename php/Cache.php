<?php

namespace DevIpsum;

use Memcached;

abstract class Cache {

	static private $memcached;

	static public function init() {
		self::$memcached = new Memcached('devipsum');
		self::$memcached->setOptions([
			//Memcached::OPT_TCP_NODELAY => true,
			//Memcached::OPT_RECV_TIMEOUT => 100000,
			//Memcached::OPT_SEND_TIMEOUT => 100000,
			//Memcached::OPT_SERVER_FAILURE_LIMIT => 25,
			//Memcached::OPT_CONNECT_TIMEOUT => 100,
			//Memcached::OPT_RETRY_TIMEOUT => 300,
			//Memcached::DISTRIBUTION => Memcached::DISTRIBUTION_CONSISTENT,
			//Memcached::OPT_REMOVE_FAILED_SERVERS => true,
			Memcached::OPT_HASH => Memcached::HASH_MURMUR,
			Memcached::OPT_SERIALIZER => Memcached::SERIALIZER_IGBINARY
		]);

		if (count(self::$memcached->getServerList()) === 0) {
			foreach (Config::$cacheServers as $host) {
				self::$memcached->addServer($host, 11211);
			}
		}
	}

	static public function get($resource, $params = []) {
		return self::$memcached->get(self::getKey($resource, $params));
	}

	static public function set($resource, $params = [], $value, $ttl = Config::SHORT_CACHE) {
		return self::$memcached->set(self::getKey($resource, $params), $value, $ttl);
	}

	static public function delete($resource, $params = []) {
		return self::$memcached->delete(self::getKey($resource, $params));
	}

	static private function getKey($resource, $params = []) {
		$cacheKey = 'devipsum:' . $resource;
		foreach ($params as $key => $value) {
			$cacheKey .= ':' . $key . '=' . $value;
		}

		return $cacheKey;
	}
}
