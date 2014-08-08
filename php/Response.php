<?php

namespace DevIpsum;

class Response {

	// codes

	const OK = 200;
	const NO_CONTENT = 204;

	const BAD_REQUEST = 400;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;
	const NOT_ACCEPTABLE = 406;
	const RANGE_NOT_SATISFIABLE = 417;

	const INTERNAL_ERROR = 500;
	const NOT_IMPLEMENTED = 501;

	// messages

	static public $messages = [
		200 => 'OK',
		204 => 'No content',

		400 => 'Bad request',
		404 => 'Not found',
		405 => 'Method not allowed',
		406 => 'Not acceptable',
		417 => 'Range not satisfiable',

		500 => 'Internal error',
		501 => 'Not implemented'
	];

	private $status;
	private $result;

	public function __construct() {
		$this->status = [];
		$this->result = [];
	}

	// result

	public function getResult() {
		return $this->result;
	}

	public function __get($key) {
		if (!isset($this->result[$key])) {
			return null;
		}

		return $this->result[$key];
	}

	public function __set($key, $value) {
		if ($value === null) {
			$this->__unset($key);
			return;
		}

		$this->result[$key] = $value;
	}

	public function __unset($key) {
		unset($this->result[$key]);
	}

	// status

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($code, $reason = null) {
		$code = (int) $code;

		if (!isset(self::$messages[$code])) {
			$this->internalError('Invalid status code');
			return;
		}

		$this->status['code'] = $code;
		$this->status['message'] = self::$messages[$code];
		$this->status['reason'] = (string) $reason;
	}

	public function okay($reason = null) {
		$this->setStatus(self::OK, $reason);
	}

	public function noContent($reason = null) {
		$this->setStatus(self::NO_CONTENT, $reason);
	}

	public function badRequest($reason = null) {
		$this->setStatus(self::BAD_REQUEST, $reason);
	}

	public function notFound($reason = null) {
		$this->setStatus(self::NOT_FOUND, $reason);
	}

	public function methodNotAllowed($reason = null) {
		$this->setStatus(self::METHOD_NOT_ALLOWED, $reason);
	}

	public function notAcceptable($reason = null) {
		$this->setStatus(self::NOT_ACCEPTABLE, $reason);
	}

	public function rangeNotSatisfiable($reason = null) {
		$this->setStatus(self::RANGE_NOT_SATISFIABLE, $reason);
	}

	public function internalError($reason = null) {
		$this->setStatus(self::INTERNAL_ERROR, $reason);
	}

	public function notImplemented($reason = null) {
		$this->SetStatus(self::NOT_IMPLEMENTED, $reason);
	}
}
