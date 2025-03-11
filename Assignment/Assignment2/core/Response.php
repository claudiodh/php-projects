<?php

namespace core;

class Response {

	private ?string $body;

	public function __construct(?string $body = null) {
		$this->body = $body;
	}

	public function setBody(string $body): Response {
		$this->body = $body;
		return $this;
	}

	public function getBody(): ?string {
		return $this->body;
	}

	public function getStatus(int $statusCode): Response {
		http_response_code($statusCode);
		return $this;
	}

}