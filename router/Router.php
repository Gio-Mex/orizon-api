<?php
// Router config
class Router
{
  private $routes = [];

  public function addRoute($method, $uri, $controller)
  {
    $this->routes[$uri][$method] = $controller;
  }

  public function getRoutes()
  {
    return $this->routes;
  }

  // Run the router
  public function route()
  {

    $_uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $_method = $_SERVER['REQUEST_METHOD'];
    $_uri = '/' . basename($_uri);

    foreach ($this->routes as $uri => $methods) {
      foreach ($methods as $method => $controller) {
        if ($uri == $_uri && $method == $_method) {
          return require $controller;
        }
      }
    }

    // If no matching route is found
    http_response_code(404);
    echo json_encode(['message' => 'Page not found']);
  }
}
?>