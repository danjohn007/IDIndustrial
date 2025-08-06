<?php
/**
 * Modelo Solicitud
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

require_once __DIR__ . '/../classes/Database.php';

class Solicitud {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Crear nueva solicitud
     */
    public function create($data) {
        $sql = "INSERT INTO solicitudes (usuario_id, tipo_servicio_id, titulo, descripcion, prioridad, 
                direccion_servicio, contacto_sitio, telefono_contacto, fecha_vencimiento, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $this->db->insert($sql, [
            $data['usuario_id'],
            $data['tipo_servicio_id'],
            $data['titulo'],
            $data['descripcion'],
            $data['prioridad'] ?? 'media',
            $data['direccion_servicio'] ?? null,
            $data['contacto_sitio'] ?? null,
            $data['telefono_contacto'] ?? null,
            $data['fecha_vencimiento'] ?? null,
            $data['observaciones'] ?? null
        ]);
    }
    
    /**
     * Obtener solicitud por ID
     */
    public function getById($id) {
        $sql = "SELECT s.*, u.nombre as cliente_nombre, u.email as cliente_email, u.telefono as cliente_telefono,
                ts.nombre as tipo_servicio_nombre, t.usuario_id as tecnico_usuario_id, ut.nombre as tecnico_nombre
                FROM solicitudes s
                LEFT JOIN usuarios u ON s.usuario_id = u.id
                LEFT JOIN tipos_servicio ts ON s.tipo_servicio_id = ts.id
                LEFT JOIN tecnicos t ON s.tecnico_id = t.id
                LEFT JOIN usuarios ut ON t.usuario_id = ut.id
                WHERE s.id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * Obtener todas las solicitudes con filtros
     */
    public function getAll($filters = []) {
        $sql = "SELECT s.*, u.nombre as cliente_nombre, u.empresa as cliente_empresa,
                ts.nombre as tipo_servicio_nombre, ut.nombre as tecnico_nombre
                FROM solicitudes s
                LEFT JOIN usuarios u ON s.usuario_id = u.id
                LEFT JOIN tipos_servicio ts ON s.tipo_servicio_id = ts.id
                LEFT JOIN tecnicos t ON s.tecnico_id = t.id
                LEFT JOIN usuarios ut ON t.usuario_id = ut.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['estado'])) {
            $sql .= " AND s.estado = ?";
            $params[] = $filters['estado'];
        }
        
        if (!empty($filters['tecnico_id'])) {
            $sql .= " AND s.tecnico_id = ?";
            $params[] = $filters['tecnico_id'];
        }
        
        if (!empty($filters['tipo_servicio_id'])) {
            $sql .= " AND s.tipo_servicio_id = ?";
            $params[] = $filters['tipo_servicio_id'];
        }
        
        if (!empty($filters['fecha_desde'])) {
            $sql .= " AND DATE(s.fecha_creacion) >= ?";
            $params[] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $sql .= " AND DATE(s.fecha_creacion) <= ?";
            $params[] = $filters['fecha_hasta'];
        }
        
        $sql .= " ORDER BY s.fecha_creacion DESC";
        
        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . intval($filters['limit']);
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Asignar técnico a solicitud
     */
    public function asignarTecnico($solicitudId, $tecnicoId) {
        $sql = "UPDATE solicitudes SET tecnico_id = ?, estado = 'asignada', fecha_asignacion = NOW() WHERE id = ?";
        return $this->db->update($sql, [$tecnicoId, $solicitudId]);
    }
    
    /**
     * Actualizar estado de solicitud
     */
    public function updateEstado($id, $estado, $data = []) {
        $fields = ["estado = ?"];
        $params = [$estado];
        
        if ($estado == 'en_proceso' && !isset($data['fecha_inicio'])) {
            $fields[] = "fecha_inicio = NOW()";
        }
        
        if ($estado == 'completada' && !isset($data['fecha_finalizacion'])) {
            $fields[] = "fecha_finalizacion = NOW()";
        }
        
        if (isset($data['costo_final'])) {
            $fields[] = "costo_final = ?";
            $params[] = $data['costo_final'];
        }
        
        if (isset($data['observaciones'])) {
            $fields[] = "observaciones = ?";
            $params[] = $data['observaciones'];
        }
        
        $params[] = $id;
        
        $sql = "UPDATE solicitudes SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->db->update($sql, $params);
    }
    
    /**
     * Actualizar costo estimado
     */
    public function updateCostoEstimado($id, $costo) {
        $sql = "UPDATE solicitudes SET costo_estimado = ? WHERE id = ?";
        return $this->db->update($sql, [$costo, $id]);
    }
    
    /**
     * Obtener estadísticas para dashboard
     */
    public function getEstadisticas($filters = []) {
        // Total de solicitudes
        $sql = "SELECT COUNT(*) as total FROM solicitudes WHERE 1=1";
        $params = [];
        
        if (!empty($filters['fecha_desde'])) {
            $sql .= " AND DATE(fecha_creacion) >= ?";
            $params[] = $filters['fecha_desde'];
        }
        
        if (!empty($filters['fecha_hasta'])) {
            $sql .= " AND DATE(fecha_creacion) <= ?";
            $params[] = $filters['fecha_hasta'];
        }
        
        $total = $this->db->fetchOne($sql, $params)['total'];
        
        // Por estado
        $sql = "SELECT estado, COUNT(*) as cantidad FROM solicitudes WHERE 1=1";
        if (!empty($params)) {
            $sql .= " AND DATE(fecha_creacion) >= ? AND DATE(fecha_creacion) <= ?";
        }
        $sql .= " GROUP BY estado";
        
        $porEstado = $this->db->fetchAll($sql, $params);
        
        // Ingresos totales
        $sql = "SELECT SUM(costo_final) as total_ingresos FROM solicitudes WHERE estado = 'completada'";
        if (!empty($params)) {
            $sql .= " AND DATE(fecha_creacion) >= ? AND DATE(fecha_creacion) <= ?";
        }
        
        $ingresos = $this->db->fetchOne($sql, $params)['total_ingresos'] ?? 0;
        
        // Por técnico
        $sql = "SELECT ut.nombre as tecnico, COUNT(*) as cantidad, SUM(s.costo_final) as ingresos
                FROM solicitudes s
                LEFT JOIN tecnicos t ON s.tecnico_id = t.id
                LEFT JOIN usuarios ut ON t.usuario_id = ut.id
                WHERE s.tecnico_id IS NOT NULL";
        if (!empty($params)) {
            $sql .= " AND DATE(s.fecha_creacion) >= ? AND DATE(s.fecha_creacion) <= ?";
        }
        $sql .= " GROUP BY s.tecnico_id, ut.nombre ORDER BY cantidad DESC";
        
        $porTecnico = $this->db->fetchAll($sql, $params);
        
        return [
            'total' => $total,
            'por_estado' => $porEstado,
            'total_ingresos' => $ingresos,
            'por_tecnico' => $porTecnico
        ];
    }
    
    /**
     * Obtener tipos de servicio
     */
    public function getTiposServicio() {
        $sql = "SELECT * FROM tipos_servicio WHERE activo = 1 ORDER BY nombre";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Agregar comentario a solicitud
     */
    public function addComentario($solicitudId, $usuarioId, $comentario) {
        $sql = "INSERT INTO comentarios (solicitud_id, usuario_id, comentario) VALUES (?, ?, ?)";
        return $this->db->insert($sql, [$solicitudId, $usuarioId, $comentario]);
    }
    
    /**
     * Obtener comentarios de solicitud
     */
    public function getComentarios($solicitudId) {
        $sql = "SELECT c.*, u.nombre as usuario_nombre FROM comentarios c 
                LEFT JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.solicitud_id = ? ORDER BY c.fecha_comentario DESC";
        return $this->db->fetchAll($sql, [$solicitudId]);
    }
}
?>