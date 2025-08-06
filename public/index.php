<?php
/**
 * Página Principal del Sistema
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once '../config/config.php';
require_once '../controllers/SolicitudController.php';

// Crear instancia del controlador
$solicitudController = new SolicitudController();

// Verificar si hay mensaje de éxito
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Procesar según el método HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitudController->create();
} else {
    $solicitudController->showForm();
}
?>