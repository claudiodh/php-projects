<?php

namespace core;

class Request {

	private array $input = [];
	private array $routeParameters = [];

	public function __construct() {
		foreach ($this->isHttpPost() ? $_POST : $_GET as $key => $value) {
			$this->input[$key] = $value;
		}
	}

	public function isAuthenticated(): bool {
		return isset($_SESSION['user_id']);
	}

	public function isGuest(): bool {
		return ! isset($_SESSION['user_id']);
	}

	/**
	 * @return string The HTTP request method. eg. "post", "get", etc.
	 */
	public function method(): string {
		return $_SERVER['REQUEST_METHOD'];
	}

	public function isHttpPost(): bool {
		return $this->method() === 'POST';
	}

	public function isHttpGet(): bool {
		return $this->method() === 'GET';
	}

	public function getPath(): bool|string {
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		return $position === false ? $path : substr($path, 0, $position);
	}

	public function input(string $key): ?string {
		return $this->input[$key] ?? null;
	}

	public function setRouteParameter($key, $value): void
    {
		$this->input[$key] = $value;
	}

}