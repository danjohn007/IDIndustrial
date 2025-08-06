<?php
/**
 * Página de Logout
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once '../config/config.php';
require_once '../controllers/AuthController.php';

// Crear instancia del controlador
$auth = new AuthController();

// Cerrar sesión
$auth->logout();
?>