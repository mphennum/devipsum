<?php

namespace DevIpsum\Handlers\WWW;

use DevIpsum\Handler;

class Home extends Handler {

	public function __construct($method, $resource, $params, $format) {
		parent::__construct($method, $resource, $params, $format);
	}

	public function handle() {
		parent::handle();
		$this->view = 'home';
	}
}
