<?php

namespace DevIpsum;

class Request {
	public $method;
	public $resouce;
	public $params;
	public $format;

	public function __construct($method, $resource, $params, $format) {
		$this->method = $method;
		$this->resource = $resource;
		$this->format = $format;
		$this->params = $params;
	}
}
