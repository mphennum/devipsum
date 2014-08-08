<?php

namespace DevIpsum;

abstract class Handler {

	public $request;
	public $response;

	public function __construct() {
		$this->request = new Request();
		$this->response = new Response();
	}

	abstract public function handle();

	static public function factory($method, $resource, $params, $format) {

	}
}
