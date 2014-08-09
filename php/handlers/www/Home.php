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

		$this->response->h1 = 'Randomly generated development ipsum';
		$this->response->content =
			'<p>source: <a href="//github.com/mphennum/devipsum/">github.com/mphennum/devipsum</a></p>' .
			'<p>docs: <a href="//github.com/mphennum/devipsum/wiki/">github.com/mphennum/devipsum/wiki</a></p>'
		;
	}
}
