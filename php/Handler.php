<?php

namespace DevIpsum;

use DevIpsum\Handlers\API\User;
use DevIpsum\Handlers\API\Text;

use DevIpsum\Handlers\WWW\Docs;
use DevIpsum\Handlers\WWW\Home;

class Handler {

	public $method;
	public $resouce;
	public $params;
	public $format;

	public $request;
	public $response;

	public function __construct($method, $resource, $params, $format) {
		$this->method = $method;
		$this->resource = $resource;
		$this->params = $params;
		$this->format = $format;

		$this->response = new Response();
	}

	public function handle() {
		// do nothing
	}

	public function view() {

	}

	// factory

	static public function factory($host, $method, $resource, $params, $format) {
		if ($method !== 'GET') {
			$handler = new self($method, $resource, $params, $format);
			$handler->response->methodNotAllowed();;
			return $handler;
		}

		if ($resource === 'user') {
			return new User($method, $resource, $params, $format);
		}

		if ($resource === 'text') {
			return new Text($method, $resource, $params, $format);
		}

		if ($resource === 'home') {
			return new Home($method, $resource, $params, $format);
		}

		if ($resource === 'docs') {
			return new Docs($method, $resource, $params, $format);
		}

		$handler = new self($method, $resource, $params, $format);
		$handler->response->badRequest();
		return $handler;
	}
}
