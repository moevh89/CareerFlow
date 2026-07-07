<?php
namespace App\Core;

class Router {
    private $routes = [];
    private $prefix = '';

    public function get($route, $callback) {
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback) {
        $this->addRoute('POST', $route, $callback);
    }

    public function patch($route, $callback) {
        $this->addRoute('PATCH', $route, $callback);
    }

    public function mount($prefix, $callback) {
        $oldPrefix = $this->prefix;
        $this->prefix .= $prefix;
        $callback();
        $this->prefix = $oldPrefix;
    }

    private function addRoute($method, $route, $callback) {
        // Convert regex patterns like (\d+) to standard named/unnamed capturing groups, but keep it simple
        $route = $this->prefix . $route;
        $routePattern = preg_replace('/\\\\(\d\+)/', '(\d+)', $route);
        $routePattern = '#^' . str_replace('/', '\/', $routePattern) . '$#';

        $this->routes[] = [
            'method' => $method,
            'pattern' => $routePattern,
            'callback' => $callback
        ];
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];

        // Parse the full URI
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // If script is in a subdirectory (e.g. /public/index.php), strip that base path out of the URI
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $baseDir = dirname($scriptName);

        // Remove base directory if it exists in URI
        if ($baseDir !== '/' && $baseDir !== '\\' && strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }

        // Remove 'index.php' if it's explicitly in the URL
        if (strpos($uri, '/index.php') === 0) {
            $uri = substr($uri, 10);
        }

        // Normalize empty URI to '/'
        if (empty($uri)) {
            $uri = '/';
        }

        // Remove trailing slash if present (but keep it if it's just '/')
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = substr($uri, 0, -1);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove the full string match

                if (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $matches);
                    return;
                }

                if (is_string($route['callback']) && strpos($route['callback'], '@') !== false) {
                    list($controllerName, $methodName) = explode('@', $route['callback']);
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $methodName], $matches);
                    return;
                }
            }
        }

        // 404
        http_response_code(404);
        echo json_encode(['error' => 'Not found', 'uri' => $uri]);
    }
}
