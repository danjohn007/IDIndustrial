<?php
/**
 * Controlador de Autenticación
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuario;
    
    public function __construct() {
        $this->usuario = new Usuario();
        
        // Configurar sesión si no está iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
        }
    }
    
    /**
     * Mostrar formulario de login
     */
    public function showLogin() {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->isAuthenticated()) {
            header('Location: dashboard.php');
            exit;
        }
        
        include __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Procesar login
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: login.php');
            exit;
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];
        
        // Validaciones
        if (empty($email)) {
            $errors[] = 'El email es requerido';
        }
        
        if (empty($password)) {
            $errors[] = 'La contraseña es requerida';
        }
        
        if (empty($errors)) {
            $user = $this->usuario->authenticate($email, $password);
            
            if ($user) {
                // Crear sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['rol'];
                $_SESSION['last_activity'] = time();
                
                // Regenerar ID de sesión por seguridad
                session_regenerate_id(true);
                
                // Redirigir al dashboard
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = 'Email o contraseña incorrectos';
            }
        }
        
        // Si hay errores, mostrar login con errores
        include __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Cerrar sesión
     */
    public function logout() {
        // Destruir la sesión
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Redirigir al login
        header('Location: login.php');
        exit;
    }
    
    /**
     * Verificar si el usuario está autenticado
     */
    public function isAuthenticated() {
        return isset($_SESSION['user_id']) && 
               isset($_SESSION['last_activity']) && 
               (time() - $_SESSION['last_activity'] < SESSION_LIFETIME);
    }
    
    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($role) {
        return $this->isAuthenticated() && 
               isset($_SESSION['user_role']) && 
               $_SESSION['user_role'] === $role;
    }
    
    /**
     * Verificar si el usuario es admin
     */
    public function isAdmin() {
        return $this->hasRole('admin');
    }
    
    /**
     * Verificar si el usuario es técnico
     */
    public function isTecnico() {
        return $this->hasRole('tecnico');
    }
    
    /**
     * Obtener información del usuario actual
     */
    public function getCurrentUser() {
        if (!$this->isAuthenticated()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'nombre' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'rol' => $_SESSION['user_role']
        ];
    }
    
    /**
     * Middleware para requerir autenticación
     */
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            header('Location: login.php');
            exit;
        }
        
        // Actualizar tiempo de actividad
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Middleware para requerir rol admin
     */
    public function requireAdmin() {
        $this->requireAuth();
        
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('Acceso denegado. Se requieren permisos de administrador.');
        }
    }
    
    /**
     * Generar token CSRF
     */
    public function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token']) || 
            !isset($_SESSION['csrf_token_time']) ||
            (time() - $_SESSION['csrf_token_time']) > CSRF_TOKEN_EXPIRE) {
            
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validar token CSRF
     */
    public function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && 
               isset($_SESSION['csrf_token_time']) &&
               (time() - $_SESSION['csrf_token_time']) <= CSRF_TOKEN_EXPIRE &&
               hash_equals($_SESSION['csrf_token'], $token);
    }
}
?>