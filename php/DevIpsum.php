<?php

namespace DevIpsum;

abstract class DevIpsum {
	static public function init() {

	}

	static public function handle($crud, $module, $resource, $vars) {

	}

	static public function handleHTTP() {
		$method = $_SERVER['REQUEST_METHOD'];
		//self::handle();
	}
}
