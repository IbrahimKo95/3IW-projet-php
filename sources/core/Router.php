<?php

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $path, string $controllerName, string $methodName, array $middlewares = []): void
    {
        $this->routes[] = [
            "method" => "GET",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName,
            "middlewares" => $middlewares
        ];
    }

    public function post(string $path, string $controllerName, string $methodName, array $middlewares = []): void
    {
        $this->routes[] = [
            "method" => "POST",
            "path" => $path,
            "controllerName" => $controllerName,
            "methodName" => $methodName,
            "middlewares" => $middlewares
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
                foreach ($route["middlewares"] as $middleware) {
                    $middlewareClass = "middlewares\\" . ucfirst($middleware) . "Middleware";
                    $middlewareFile = __DIR__ . "/../middlewares/" . ucfirst($middleware) . "Middleware.php";
                    require_once $middlewareFile;
                    if (class_exists($middlewareClass)) {
                        $middlewareClass::handle();
                    } else {
                        throw new Exception("Middleware $middlewareClass non trouvé.");
                    }
                }


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
