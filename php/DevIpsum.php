<?php

namespace DevIpsum;

abstract class DevIpsum {
	static public function init() {

	}

	static public function handle() {
		$method = null;
		if (isset($_SERVER['REQUEST_METHOD'])) {
			$method = $_SERVER['REQUEST_METHOD'];
		}

		$resource = null;
		if (isset($_SERVER['REQUEST_URI'])) {
			$request = $_SERVER['REQUEST_URI'];
		}

		$ip = null;
		if (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$host = null;
		if (isset($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		}

		$agent = null;
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
	}
}
