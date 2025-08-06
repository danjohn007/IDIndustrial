<?php
/**
 * Controlador del Dashboard
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class DashboardController {
    private $solicitud;
    private $usuario;
    private $auth;
    
    public function __construct() {
        $this->solicitud = new Solicitud();
        $this->usuario = new Usuario();
        $this->auth = new AuthController();
    }
    
    /**
     * Mostrar dashboard principal
     */
    public function index() {
        $this->auth->requireAuth();
        
        $currentUser = $this->auth->getCurrentUser();
        
        // Obtener filtros
        $filters = [
            'fecha_desde' => $_GET['fecha_desde'] ?? date('Y-m-01'), // Primer día del mes actual
            'fecha_hasta' => $_GET['fecha_hasta'] ?? date('Y-m-d'),  // Hoy
            'tecnico_id' => $_GET['tecnico_id'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'tipo_servicio_id' => $_GET['tipo_servicio_id'] ?? ''
        ];
        
        // Obtener estadísticas generales
        $estadisticas = $this->solicitud->getEstadisticas($filters);
        
        // Obtener solicitudes recientes
        $solicitudesRecientes = $this->solicitud->getAll(array_merge($filters, ['limit' => 10]));
        
        // Datos para filtros
        $tecnicos = $this->usuario->getTecnicos();
        $tiposServicio = $this->solicitud->getTiposServicio();
        
        // Datos para gráficas
        $graficoEstados = $this->getDataGraficoEstados($filters);
        $graficoTecnicos = $this->getDataGraficoTecnicos($filters);
        $graficoIngresos = $this->getDataGraficoIngresos($filters);
        $graficoTiposServicio = $this->getDataGraficoTiposServicio($filters);
        
        include __DIR__ . '/../views/dashboard/index.php';
    }
    
    /**
     * Datos para gráfico de estados
     */
    private function getDataGraficoEstados($filters) {
        $estadisticas = $this->solicitud->getEstadisticas($filters);
        $data = [
            'labels' => [],
            'data' => [],
            'colors' => []
        ];
        
        $colores = [
            'pendiente' => '#ffc107',
            'asignada' => '#17a2b8',
            'en_proceso' => '#007bff',
            'completada' => '#28a745',
            'cancelada' => '#dc3545'
        ];
        
        foreach ($estadisticas['por_estado'] as $item) {
            $data['labels'][] = ucfirst(str_replace('_', ' ', $item['estado']));
            $data['data'][] = $item['cantidad'];
            $data['colors'][] = $colores[$item['estado']] ?? '#6c757d';
        }
        
        return $data;
    }
    
    /**
     * Datos para gráfico de técnicos
     */
    private function getDataGraficoTecnicos($filters) {
        $estadisticas = $this->solicitud->getEstadisticas($filters);
        $data = [
            'labels' => [],
            'data' => []
        ];
        
        foreach ($estadisticas['por_tecnico'] as $item) {
            $data['labels'][] = $item['tecnico'] ?? 'Sin asignar';
            $data['data'][] = $item['cantidad'];
        }
        
        return $data;
    }
    
    /**
     * Datos para gráfico de ingresos mensuales
     */
    private function getDataGraficoIngresos($filters) {
        $sql = "SELECT 
                    DATE_FORMAT(fecha_finalizacion, '%Y-%m') as mes,
                    SUM(costo_final) as ingresos
                FROM solicitudes 
                WHERE estado = 'completada' 
                AND fecha_finalizacion IS NOT NULL
                AND fecha_finalizacion >= DATE_SUB(NOW(), INTERVAL 12 MONTH)";
        
        $params = [];
        
        if (!empty($filters['fecha_desde'])) {
            $sql .= " AND DATE(fecha_finalizacion) >= ?";
            $params[] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $sql .= " AND DATE(fecha_finalizacion) <= ?";
            $params[] = $filters['fecha_hasta'];
        }
        
        $sql .= " GROUP BY mes ORDER BY mes";
        
        $db = Database::getInstance();
        $resultados = $db->fetchAll($sql, $params);
        
        $data = [
            'labels' => [],
            'data' => []
        ];
        
        foreach ($resultados as $item) {
            $fecha = DateTime::createFromFormat('Y-m', $item['mes']);
            $data['labels'][] = $fecha->format('M Y');
            $data['data'][] = floatval($item['ingresos']);
        }
        
        return $data;
    }
    
    /**
     * Datos para gráfico de tipos de servicio
     */
    private function getDataGraficoTiposServicio($filters) {
        $sql = "SELECT 
                    ts.nombre,
                    COUNT(s.id) as cantidad
                FROM tipos_servicio ts
                LEFT JOIN solicitudes s ON ts.id = s.tipo_servicio_id";
        
        $params = [];
        
        if (!empty($filters['fecha_desde']) || !empty($filters['fecha_hasta'])) {
            $sql .= " WHERE 1=1";
            
            if (!empty($filters['fecha_desde'])) {
                $sql .= " AND DATE(s.fecha_creacion) >= ?";
                $params[] = $filters['fecha_desde'];
            }
            
            if (!empty($filters['fecha_hasta'])) {
                $sql .= " AND DATE(s.fecha_creacion) <= ?";
                $params[] = $filters['fecha_hasta'];
            }
        }
        
        $sql .= " GROUP BY ts.id, ts.nombre ORDER BY cantidad DESC";
        
        $db = Database::getInstance();
        $resultados = $db->fetchAll($sql, $params);
        
        $data = [
            'labels' => [],
            'data' => []
        ];
        
        foreach ($resultados as $item) {
            $data['labels'][] = $item['nombre'];
            $data['data'][] = $item['cantidad'];
        }
        
        return $data;
    }
    
    /**
     * API para obtener datos de ingresos
     */
    public function apiIngresos() {
        $this->auth->requireAuth();
        
        header('Content-Type: application/json');
        
        $filters = [
            'fecha_desde' => $_GET['fecha_desde'] ?? date('Y-m-01'),
            'fecha_hasta' => $_GET['fecha_hasta'] ?? date('Y-m-d')
        ];
        
        $estadisticas = $this->solicitud->getEstadisticas($filters);
        
        echo json_encode([
            'total_ingresos' => $estadisticas['total_ingresos'],
            'total_solicitudes' => $estadisticas['total'],
            'por_estado' => $estadisticas['por_estado'],
            'por_tecnico' => $estadisticas['por_tecnico']
        ]);
    }
    
    /**
     * Exportar datos a CSV
     */
    public function exportCSV() {
        $this->auth->requireAuth();
        
        $filters = [
            'fecha_desde' => $_GET['fecha_desde'] ?? '',
            'fecha_hasta' => $_GET['fecha_hasta'] ?? '',
            'estado' => $_GET['estado'] ?? '',
            'tecnico_id' => $_GET['tecnico_id'] ?? ''
        ];
        
        $solicitudes = $this->solicitud->getAll($filters);
        
        $filename = 'solicitudes_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezados
        fputcsv($output, [
            'ID',
            'Título',
            'Cliente',
            'Empresa',
            'Tipo de Servicio',
            'Técnico',
            'Estado',
            'Prioridad',
            'Costo Final',
            'Fecha Creación',
            'Fecha Finalización'
        ]);
        
        // Datos
        foreach ($solicitudes as $solicitud) {
            fputcsv($output, [
                $solicitud['id'],
                $solicitud['titulo'],
                $solicitud['cliente_nombre'],
                $solicitud['cliente_empresa'],
                $solicitud['tipo_servicio_nombre'],
                $solicitud['tecnico_nombre'] ?? 'Sin asignar',
                ucfirst(str_replace('_', ' ', $solicitud['estado'])),
                ucfirst($solicitud['prioridad']),
                $solicitud['costo_final'] ? '$' . number_format($solicitud['costo_final'], 2) : '',
                $solicitud['fecha_creacion'],
                $solicitud['fecha_finalizacion'] ?? ''
            ]);
        }
        
        fclose($output);
    }
}
?>