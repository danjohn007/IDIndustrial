<?php
/**
 * Configuración General del Sistema
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// URL Base del sistema
define('BASE_URL', 'https://idindustrial.com.mx/admin/');

// Configuración de la aplicación
define('APP_NAME', 'ID INDUSTRIAL - Sistema de Solicitudes');
define('APP_VERSION', '1.0.0');
define('APP_TIMEZONE', 'America/Mexico_City');
define('APP_DEBUG', true); // Cambiar a false en producción

// Configuración de sesión
define('SESSION_LIFETIME', 3600); // 1 hora
define('SESSION_NAME', 'IDINDUSTRIAL_SESSION');

// Configuración de seguridad
define('SECURITY_SALT', 'IDIndustrial2025_Salt');
define('CSRF_TOKEN_EXPIRE', 1800); // 30 minutos

// Configuración de archivos
define('UPLOAD_PATH', 'uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB

// Establecer zona horaria
date_default_timezone_set(APP_TIMEZONE);

// Incluir configuración de base de datos
require_once __DIR__ . '/database.php';

?>