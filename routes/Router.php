<?php

class Router {
    private $routes = [];
    
    public function __construct() {
        $this->loadRoutes();
    }
    
    private function loadRoutes() {
        // Rutas públicas
        $this->routes['GET']['/'] = ['PublicController', 'index'];
        $this->routes['GET']['/inicio'] = ['PublicController', 'index'];
        $this->routes['POST']['/submit-request'] = ['PublicController', 'submitRequest'];
        $this->routes['GET']['/check-status'] = ['PublicController', 'checkStatus'];
        
        // Rutas de autenticación
        $this->routes['GET']['/admin/login'] = ['AuthController', 'login'];
        $this->routes['POST']['/admin/login'] = ['AuthController', 'authenticate'];
        $this->routes['GET']['/admin/logout'] = ['AuthController', 'logout'];
        
        // Rutas del admin
        $this->routes['GET']['/admin'] = ['AdminController', 'index'];
        $this->routes['GET']['/admin/dashboard'] = ['AdminController', 'index'];
        $this->routes['GET']['/admin/requests'] = ['AdminController', 'requests'];
        $this->routes['GET']['/admin/request'] = ['AdminController', 'viewRequest'];
        $this->routes['POST']['/admin/update-request'] = ['AdminController', 'updateRequest'];
        $this->routes['GET']['/admin/export-csv'] = ['AdminController', 'exportCSV'];
        $this->routes['GET']['/admin/users'] = ['AdminController', 'users'];
    }
    
    public function route($method, $uri) {
        // Limpiar URI
        $uri = $this->cleanUri($uri);
        
        // Buscar ruta exacta
        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $this->callController($route[0], $route[1]);
            return;
        }
        
        // Ruta no encontrada
        $this->notFound();
    }
    
    private function cleanUri($uri) {
        // Remover query string
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Remover trailing slash excepto para root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }
        
        return $uri;
    }
    
    private function callController($controllerName, $methodName) {
        try {
            $controller = new $controllerName();
            
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                $this->notFound();
            }
        } catch (Exception $e) {
            $this->serverError($e->getMessage());
        }
    }
    
    private function notFound() {
        http_response_code(404);
        include_once __DIR__ . '/../views/errors/404.php';
    }
    
    private function serverError($message = '') {
        http_response_code(500);
        include_once __DIR__ . '/../views/errors/500.php';
    }
}