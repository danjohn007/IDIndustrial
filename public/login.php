<?php
/**
 * Página de Login
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once '../config/config.php';
require_once '../controllers/AuthController.php';

// Crear instancia del controlador
$auth = new AuthController();

// Procesar según el método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->processLogin();
} else {
    $auth->showLogin();
}
?>