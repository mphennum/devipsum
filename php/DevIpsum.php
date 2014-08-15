<?php

namespace DevIpsum;

use DateTimeZone;

abstract class DevIpsum {

	static public $error;
	static public $dtz;

	static public $api;
	static public $host;
	static public $method;
	static public $ip;
	static public $agent;
	static public $params;
	static public $resource;
	static public $format;

	static public function init() {
		if (!Config::DEV_MODE) {
			ob_start();
		}

		self::$error = false;
		self::$dtz = new DateTimeZone('UTC');

		Database::init();
		Cache::init();

		self::$api = null;
		self::$host = null;
		self::$method = null;
		self::$ip = null;
		self::$agent = null;
		self::$params = [];
		self::$resource = null;
		self::$format = null;
	}

	static public function handle() {
		register_shutdown_function('DevIpsum\DevIpsum::fatalHandler');

		// host
		if (isset($_SERVER['HTTP_HOST'])) {
			self::$host = $_SERVER['HTTP_HOST'];
		}

		self::$api = (self::$host === Config::API_HOST);

		// method
		if (isset($_SERVER['REQUEST_METHOD'])) {
			self::$method = $_SERVER['REQUEST_METHOD'];
		}

		// headers
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			//header(Access-Control-Allow-Headers: ');
			//header(Access-Control-Expose-Headers: ');
			//header('Access-Control-Allow-Credentials: true']);
		}

		// CORS
		if (self::$method === 'OPTIONS') {
			header('Access-Control-Max-Age: 86400'); // 1 day

			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
				header('Access-Control-Allow-Methods: GET, OPTIONS');
			}

			exit(0);
		}

		// ip
		if (isset($_SERVER['REMOTE_ADDR'])) {
			self::$ip = $_SERVER['REMOTE_ADDR'];
		}

		// user agent
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			self::$agent = $_SERVER['HTTP_USER_AGENT'];
		}

		// params
		if (self::$method === 'GET') {
			self::$params = $_GET;
		}

		// request
		self::$format = (self::$api ? 'json' : 'html');
		if (isset($_SERVER['REQUEST_URI'])) {
			$request = $_SERVER['REQUEST_URI'];
			$request = preg_replace('/\?.*$/', '', $request);

			$request = trim($request);
			$request = trim($request, '/');
			$request = explode('.', $request);

			self::$resource = $request[0];

			$len = count($request);
			if ($len > 1) {
				self::$format = $request[$len - 1];
			}
		}

		// handler
		try {
			if (self::$api) {
				$handler = Handler::apiFactory(self::$method, self::$resource, self::$params, self::$format);
			} else {
				$handler = Handler::wwwFactory(self::$method, self::$resource, self::$params, self::$format);
			}

			if ($handler !== null) {
				$handler->handle();
				if (!Config::DEV_MODE) {
					ob_end_clean();
				}

				$handler->view(self::$api ? 'api' : 'www');
			}
		} catch (Exception $exception) {
			self::internalError($exception);
		}
	}

	static public function fatalHandler() {
		if (error_get_last() !== null) {
			//echo error_get_last();
			self::internalError('A fatal server error has occurred');
		}
	}

	static public function internalError($message = null) {
		self::$error = true;

		$action = (isset(Handler::$actions[self::$method]) ? Handler::$actions[self::$method] : strtolower(self::$method));
		$message = ($message === null ? 'An unknown error has occurred' : $message);

		$handler = new Handler($action, self::$resource, self::$params, self::$format);
		$handler->handle();
		$handler->response->internalError($message);
		if (!Config::DEV_MODE) {
			ob_end_clean();
		}

		$handler->view(self::$api ? 'api' : 'www', true);
	}
}
