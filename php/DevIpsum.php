<?php

namespace DevIpsum;

abstract class DevIpsum {
	static public function init() {

	}

	static public function handle() {
		$host = null;
		if (isset($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		}

		$method = null;
		if (isset($_SERVER['REQUEST_METHOD'])) {
			$method = $_SERVER['REQUEST_METHOD'];
		}

		if ($method === 'OPTIONS') {
			// options headers, allow all
		}

		$ip = null;
		if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$agent = null;
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}

		$params = [];
		if ($method === 'GET') {
			$params = $_GET;
		}

		$resource = null;
		$format = null;
		if (isset($_SERVER['REQUEST_URI'])) {
			$request = $_SERVER['REQUEST_URI'];
			$request = preg_replace('/\?.*$/', '', $request);

			$request = trim($request);
			$request = trim($request, '/');
			$request = explode('.', $request);

			$resource = $request[0];

			$len = count($request);
			if ($len === 1) {
				$format = 'json';
			} else {
				$format = $request[$len - 1];
			}
		}

		//$handler = Handler::factory($method, $resource, $params, $format)
		//$handler->handle();
	}
}
