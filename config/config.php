<?php

// Configuración general del sistema
define('BASE_URL', 'http://localhost/solicitudes-industriales/');
define('APP_NAME', 'ID Industrial - Sistema de Solicitudes');
define('APP_VERSION', '1.0.0');

// Configuración de sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Autoload de clases
spl_autoload_register(function ($class_name) {
    $directories = [
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
        __DIR__ . '/../helpers/',
        __DIR__ . '/../config/',
        __DIR__ . '/../routes/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Iniciar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}