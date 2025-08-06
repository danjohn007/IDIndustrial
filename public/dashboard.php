<?php
/**
 * Dashboard Administrativo
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once '../config/config.php';
require_once '../controllers/DashboardController.php';
require_once '../controllers/SolicitudController.php';

// Crear instancias de controladores
$dashboard = new DashboardController();
$solicitudController = new SolicitudController();

// Verificar autenticación
$dashboard->auth->requireAuth();

// Manejar diferentes vistas y acciones
$view = $_GET['view'] ?? 'dashboard';
$action = $_GET['action'] ?? '';

switch ($view) {
    case 'solicitud':
        if (isset($_GET['id'])) {
            $solicitudController->view($_GET['id']);
        } else {
            $solicitudController->index();
        }
        break;
        
    case 'solicitudes':
        $solicitudController->index();
        break;
        
    default:
        // Manejar acciones específicas
        if ($action === 'asignar_tecnico' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitudController->asignarTecnico();
        } elseif ($action === 'update_estado' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitudController->updateEstado();
        } elseif ($action === 'add_comentario' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitudController->addComentario();
        } elseif (isset($_GET['export']) && $_GET['export'] === 'csv') {
            $dashboard->exportCSV();
        } else {
            // Dashboard principal
            $dashboard->index();
        }
        break;
}
?>