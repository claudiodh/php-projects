<?php

namespace core;

class Application {

    private Router $router;
    private Request $request;
    private Response $response;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(): void {
        // Check if session is not active before starting it
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->router->resolve();
    }

}
