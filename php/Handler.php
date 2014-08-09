<?php

namespace DevIpsum;

use DevIpsum\Handlers\API\User;
use DevIpsum\Handlers\API\Text;

use DevIpsum\Handlers\WWW\Docs;
use DevIpsum\Handlers\WWW\Home;

class Handler {

	static public $actions = [
		'POST' => 'create',
		'GET' => 'read',
		'PUT' => 'update',
		'DELETE' => 'delete'
	];

	static public $formats = [
		'home' => 'home.html',
		'error' => 'error.html',

		'json' => 'json',
		'xml' => 'xml'
	];

	public $action;
	public $resouce;
	public $params;
	public $format;
	public $view;

	public $request;
	public $response;

	public function __construct($action, $resource, $params, $format) {
		$this->action = $action;
		$this->resource = $resource;
		$this->params = $params;
		$this->format = $format;

		$this->view = null;

		$this->response = new Response();
	}

	public function handle() {
		// do nothing
	}

	public function view() {
		$request = [
			'action' => $this->action,
			'resource' => $this->resource,
			'params' => $this->params,
			'format' => $this->format
		];

		$result = $this->response->getResult();
		$status = $this->response->getStatus();

		//echo json_encode($request, JSON_PRETTY_PRINT), "\n", json_encode($result, JSON_PRETTY_PRINT), "\n", json_encode($status, JSON_PRETTY_PRINT), "\n";

		foreach ($result as $key => $val) {
			if ($key === 'request' || $key === 'result' || $key === 'status') {
				$handler = new self($this->action, $this->resource, $this->params, $this->format);
				$handler->response->internalError('Bad variable name: "' . $key . '"');
				return;
			}

			$$key = $val;
		}

		if ($this->view === null) {
			$this->view = $this->format;
		}

		include __DIR__ . '/views/' . self::$formats[$this->view] . '.php';
	}

	// factory

	static public function apiFactory($method, $resource, $params, $format) {
		$action = (isset(self::$actions[$method]) ? self::$actions[$method] : strtolower($method));

		foreach ($params as &$param) {
			$param = self::decodeParam($param);
		}

		if (!isset(self::$formats[$format])) {
			$handler = new self($action, $resource, $params, 'json');
			$handler->handle();
			$handler->response->notImplemented('Format not supported: "' . $format . '"');
			return $handler;
		}

		if ($action !== 'read') {
			$handler = new self($action, $resource, $params, $format);
			$handler->handle();
			$handler->response->methodNotAllowed('Method not allowed: "' . $method . '"');
			return $handler;
		}

		if ($resource === 'user') {
			return new User($action, $resource, $params, $format);
		}

		if ($resource === 'text') {
			return new Text($action, $resource, $params, $format);
		}

		$handler = new self($action, $resource, $params, $format);
		$handler->handle();
		$handler->response->badRequest();
		return $handler;
	}

	static public function wwwFactory($method, $resource, $params, $format) {
		$action = (isset(self::$actions[$method]) ? self::$actions[$method] : strtolower($method));

		foreach ($params as &$param) {
			$param = self::decodeParam($param);
		}

		if ($format !== 'html') {
			$handler = new self($action, $resource, $params, 'html');
			$handler->handle();
			$handler->response->notImplemented('Format not supported: "' . $format . '"');
			$handler->view = 'error';
			$handler->response->h1 = '404 not found';
			$handler->response->content = '';
			return $handler;
		}

		if ($action !== 'read') {
			$handler = new self($action, $resource, $params, $format);
			$handler->handle();
			$handler->response->methodNotAllowed('Method not allowed: "' . $method . '"');
			return $handler;
		}

		if ($format !== 'html') {
			$handler = new self($action, $resource, $params, 'html');
			$handler->handle();
			$handler->response->notFound('Format not supported: "' . $format . '"');
			$handler->response->h1 = '404 not found';
			$handler->response->content = '';
			return $hander;
		}

		if ($resource === '') {
			return new Home($action, 'home', $params, $format);
		}

		$handler = new self($action, $resource, $params, $format);
		$handler->handle();
		$handler->view = 'error';
		$handler->response->badRequest();
		$handler->response->h1 = '404 not found';
		$handler->response->content = '';
		return $handler;
	}

	// params

	static private function decodeParam($param) {
		$param = rawurldecode($param);

		if ($param === '' || $param === 'true') {
			return true;
		}

		if ($param === 'false') {
			return false;
		}

		if ($param === 'null') {
			return null;
		}

		if (preg_match('/^[0-9]+$/', $param)) {
			return (int) $param;
		}

		if (preg_match('/^[0-9]?\.[0-9]+$/', $param)) {
			return (float) $param;
		}

		if (preg_match('/^[^,]+(,[^,]+)+$/', $param)) {
			$params = explode(',', $param);
			foreach ($params as &$param) {
				$param = self::decodeParam($param);
			}

			return $params;
		}

		return $param;
	}
}
