<?php
// Archivo principal del sistema
require_once __DIR__ . '/../config/config.php';

// Obtener método y URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remover base path si existe
$base_path = parse_url(BASE_URL, PHP_URL_PATH);
if ($base_path && strpos($uri, $base_path) === 0) {
    $uri = substr($uri, strlen($base_path));
}

// Crear router y procesar ruta
$router = new Router();
$router->route($method, $uri);
?>