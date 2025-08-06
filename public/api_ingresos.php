<?php
/**
 * API de Ingresos
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once '../config/config.php';
require_once '../controllers/DashboardController.php';

// Crear instancia del controlador
$dashboard = new DashboardController();

// Verificar autenticación
$dashboard->auth->requireAuth();

// Devolver datos JSON
$dashboard->apiIngresos();
?>