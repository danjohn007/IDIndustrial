<?php

class Helper {
    
    // Función para sanitizar datos de entrada
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    
    // Función para validar email
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    // Función para validar teléfono (básico)
    public static function validatePhone($phone) {
        return preg_match('/^[0-9\s\-\+\(\)]+$/', $phone);
    }
    
    // Función para generar token CSRF
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    // Función para verificar token CSRF
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    // Función para formatear fechas
    public static function formatDate($date, $format = 'd/m/Y H:i') {
        if (empty($date)) return '-';
        return date($format, strtotime($date));
    }
    
    // Función para obtener el texto del estado
    public static function getStatusText($status) {
        $statuses = [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado'
        ];
        return $statuses[$status] ?? ucfirst($status);
    }
    
    // Función para obtener la clase CSS del estado
    public static function getStatusClass($status) {
        $classes = [
            'pendiente' => 'warning',
            'en_proceso' => 'info',
            'completado' => 'success',
            'cancelado' => 'danger'
        ];
        return $classes[$status] ?? 'secondary';
    }
    
    // Función para obtener el texto de la prioridad
    public static function getPriorityText($priority) {
        $priorities = [
            'baja' => 'Baja',
            'media' => 'Media',
            'alta' => 'Alta',
            'urgente' => 'Urgente'
        ];
        return $priorities[$priority] ?? ucfirst($priority);
    }
    
    // Función para obtener la clase CSS de la prioridad
    public static function getPriorityClass($priority) {
        $classes = [
            'baja' => 'secondary',
            'media' => 'info',
            'alta' => 'warning',
            'urgente' => 'danger'
        ];
        return $classes[$priority] ?? 'secondary';
    }
    
    // Función para obtener el texto del tipo de servicio
    public static function getServiceTypeText($type) {
        $types = [
            'mantenimiento' => 'Mantenimiento Industrial',
            'instalacion' => 'Instalación de Equipos',
            'reparacion' => 'Reparación de Maquinaria',
            'consultoria' => 'Consultoría Técnica',
            'otro' => 'Otro'
        ];
        return $types[$type] ?? ucfirst($type);
    }
    
    // Función para redireccionar
    public static function redirect($url) {
        header("Location: " . $url);
        exit;
    }
    
    // Función para establecer mensaje flash
    public static function setFlashMessage($type, $message) {
        $_SESSION[$type] = $message;
    }
    
    // Función para obtener y limpiar mensaje flash
    public static function getFlashMessage($type) {
        if (isset($_SESSION[$type])) {
            $message = $_SESSION[$type];
            unset($_SESSION[$type]);
            return $message;
        }
        return null;
    }
    
    // Función para logging básico
    public static function log($message, $level = 'INFO') {
        $log_file = __DIR__ . '/../logs/app.log';
        $log_dir = dirname($log_file);
        
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
    }
    
    // Función para debugging (solo en desarrollo)
    public static function debug($data, $die = false) {
        if (defined('DEBUG') && DEBUG === true) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
            
            if ($die) {
                die();
            }
        }
    }
    
    // Función para paginar resultados
    public static function paginate($total_items, $per_page = 10, $current_page = 1) {
        $total_pages = ceil($total_items / $per_page);
        $current_page = max(1, min($current_page, $total_pages));
        $offset = ($current_page - 1) * $per_page;
        
        return [
            'total_items' => $total_items,
            'per_page' => $per_page,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'offset' => $offset,
            'has_previous' => $current_page > 1,
            'has_next' => $current_page < $total_pages
        ];
    }
}