<?php
namespace App\Core;

final class Router {
  private array $routes = [];
  private string $base;

  public function __construct(string $base = '/') { $this->base = rtrim($base,'/'); }

  public function get(string $path, string $action): void  { $this->map('GET',$path,$action); }
  public function post(string $path, string $action): void { $this->map('POST',$path,$action); }

  private function map(string $method, string $path, string $action): void {
    $regex = '#^' . preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#','(?P<$1>[^/]+)', rtrim($path,'/')) . '$#';
    $this->routes[] = compact('method','regex','action');
  }

  public function dispatch(): void {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    $path = '/' . ltrim(substr($uri, strlen($this->base)), '/');
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    foreach ($this->routes as $route) {
      if ($route['method'] === $method && preg_match($route['regex'], rtrim($path,'/'), $m)) {
        [$class,$methodAction] = explode('@',$route['action']);
        $ctrl = new $class();
        $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
        echo $ctrl->$methodAction(...array_values($params));
        return;
      }
    }
    http_response_code(404);
    echo '404 Not Found';
  }
}
