<?php
/**
 * Modelo Usuario
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

require_once __DIR__ . '/../classes/Database.php';

class Usuario {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Autenticar usuario
     */
    public function authenticate($email, $password) {
        $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? AND activo = 1";
        $user = $this->db->fetchOne($sql, [$email]);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Obtener usuario por ID
     */
    public function getById($id) {
        $sql = "SELECT id, nombre, email, telefono, empresa, rol, activo, fecha_registro FROM usuarios WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * Obtener todos los técnicos
     */
    public function getTecnicos() {
        $sql = "SELECT u.id, u.nombre, u.email, u.telefono, t.especialidad, t.experiencia_años 
                FROM usuarios u 
                INNER JOIN tecnicos t ON u.id = t.usuario_id 
                WHERE u.rol = 'tecnico' AND u.activo = 1 AND t.activo = 1 
                ORDER BY u.nombre";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Crear nuevo usuario
     */
    public function create($data) {
        $sql = "INSERT INTO usuarios (nombre, email, password, telefono, empresa, rol) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $this->db->insert($sql, [
            $data['nombre'],
            $data['email'],
            $hashedPassword,
            $data['telefono'] ?? null,
            $data['empresa'] ?? null,
            $data['rol'] ?? 'cliente'
        ]);
    }
    
    /**
     * Actualizar usuario
     */
    public function update($id, $data) {
        $fields = [];
        $params = [];
        
        if (isset($data['nombre'])) {
            $fields[] = "nombre = ?";
            $params[] = $data['nombre'];
        }
        
        if (isset($data['email'])) {
            $fields[] = "email = ?";
            $params[] = $data['email'];
        }
        
        if (isset($data['telefono'])) {
            $fields[] = "telefono = ?";
            $params[] = $data['telefono'];
        }
        
        if (isset($data['empresa'])) {
            $fields[] = "empresa = ?";
            $params[] = $data['empresa'];
        }
        
        if (isset($data['password'])) {
            $fields[] = "password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $params[] = $id;
        
        $sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->db->update($sql, $params);
    }
    
    /**
     * Verificar si el email ya existe
     */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        return $this->db->fetchOne($sql, $params) !== false;
    }
}
?>