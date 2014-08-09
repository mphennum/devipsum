<?php

namespace DevIpsum;

abstract class DevIpsum {
	static public function init() {

	}

	static public function handle() {
		// host
		$host = null;
		if (isset($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		}

		// method
		$method = null;
		if (isset($_SERVER['REQUEST_METHOD'])) {
			$method = $_SERVER['REQUEST_METHOD'];
		}

		// headers
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			//header(Access-Control-Allow-Headers: ');
			//header(Access-Control-Expose-Headers: ');
			//header('Access-Control-Allow-Credentials: true']);
		}

		// CORS
		if ($method === 'OPTIONS') {
			header('Access-Control-Max-Age: 86400'); // 1 day

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
				header('Access-Control-Allow-Methods: GET, OPTIONS');
			}
		}

		// ip
		$ip = null;
		if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		// user agent
		$agent = null;
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}

		// params
		$params = [];
		if ($method === 'GET') {
			$params = $_GET;
		}

		// request
		$resource = null;
		$format = 'json';
		if (isset($_SERVER['REQUEST_URI'])) {
			$request = $_SERVER['REQUEST_URI'];
			$request = preg_replace('/\?.*$/', '', $request);

			$request = trim($request);
			$request = trim($request, '/');
			$request = explode('.', $request);

			$resource = $request[0];

			$len = count($request);
			if ($len > 1) {
				$format = $request[$len - 1];
			}
		}

		// handler
		$handler = Handler::factory($host, $method, $resource, $params, $format);
		$handler->handle();

		// view
	}
}
