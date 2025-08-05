<?php
/**
 * Configuración de Base de Datos
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Configuración de conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'idindust_solicitudes');
define('DB_USER', 'idindust_solicitudes');
define('DB_PASS', 'Danjohn007');
define('DB_CHARSET', 'utf8mb4');

// Configuración de PDO
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

?>