<?php

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Mostrar formulario de login
    public function login() {
        // Si ya está logueado, redireccionar al admin
        if (isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "admin");
            exit;
        }
        
        include_once __DIR__ . '/../views/admin/login.php';
    }

    // Procesar login
    public function authenticate() {
        if ($_POST) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors[] = "El usuario es requerido.";
            }
            if (empty($password)) {
                $errors[] = "La contraseña es requerida.";
            }

            if (empty($errors)) {
                if ($this->user->authenticate($username, $password)) {
                    // Establecer sesión
                    $_SESSION['user_id'] = $this->user->id;
                    $_SESSION['username'] = $this->user->username;
                    $_SESSION['full_name'] = $this->user->full_name;
                    $_SESSION['role'] = $this->user->role;
                    $_SESSION['last_activity'] = time();

                    // Redireccionar al admin
                    header("Location: " . BASE_URL . "admin");
                    exit;
                } else {
                    $errors[] = "Usuario o contraseña incorrectos.";
                }
            }

            include_once __DIR__ . '/../views/admin/login.php';
        } else {
            header("Location: " . BASE_URL . "admin/login");
            exit;
        }
    }

    // Cerrar sesión
    public function logout() {
        // Destruir sesión
        session_destroy();
        
        // Redireccionar al login
        header("Location: " . BASE_URL . "admin/login");
        exit;
    }

    // Verificar si el usuario está autenticado
    public static function isAuthenticated() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['last_activity'])) {
            return false;
        }

        // Verificar tiempo de inactividad (30 minutos)
        if (time() - $_SESSION['last_activity'] > 1800) {
            session_destroy();
            return false;
        }

        // Actualizar tiempo de actividad
        $_SESSION['last_activity'] = time();
        return true;
    }

    // Verificar si el usuario es admin
    public static function isAdmin() {
        return self::isAuthenticated() && $_SESSION['role'] === 'admin';
    }

    // Middleware para proteger rutas
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header("Location: " . BASE_URL . "admin/login");
            exit;
        }
    }

    // Middleware para rutas de admin
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header("Location: " . BASE_URL . "admin/login");
            exit;
        }
    }
}