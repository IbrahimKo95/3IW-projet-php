<?php

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $path, string $controllerName, string $methodName): void
    {
        $this->routes[] = [
            "method" => "GET",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function post(string $path, string $controllerName, string $methodName): void
    {
        $this->routes[] = [
            "method" => "POST",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName
        ];
    }

    public function start(): void
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];

        $path = rtrim($path, '/');

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)}/', '(?P<$1>[a-zA-Z0-9_]+)', $route['path']);
            if ($method === $route["method"] && preg_match('#^' . $pattern . '$#', $path, $matches)) {
                $methodName = $route["methodName"];
                $controllerName = $route["controllerName"];
                $controller = new $controllerName();
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }
                call_user_func_array([$controller, $methodName], $params);
                return;
            }
        }
    }
}
