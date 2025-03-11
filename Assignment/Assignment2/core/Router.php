<?php

namespace core;

require_once __DIR__ . '/../routes/web.php';

class Router
{
    private Request $request;
    private ?Response $response;
    private static array $routes = [];

    public function __construct(Request $request, ?Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function get(string $path, array $callable): void
    {
        $callable[0] = new $callable[0]();
        self::$routes['GET'][$path] = $callable;
    }

    public static function post(string $path, array $callable): void
    {
        $callable[0] = new $callable[0]();
        self::$routes['POST'][$path] = $callable;
    }

    public function resolve(): ?Response
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = self::$routes[$method][$path] ?? false;
        if ($callback) {
            $this->response = call_user_func($callback, $this->request);
        }

        // Check for route parameters
        foreach (self::$routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                preg_match_all('/\{([a-zA-Z0-9_]+)}/', $route, $paramNames);
                $paramNames = $paramNames[1]; // Extract parameter names

                // Add parameters to request object
                foreach ($paramNames as $index => $name) {
                    $this->request->setRouteParameter($name, $matches[0]);
                }

                $this->response = call_user_func($callback, $this->request);
                return $this->response;
            }
        }

        $this->response = (new Response())->getStatus(404);
        return $this->response;
    }

}
