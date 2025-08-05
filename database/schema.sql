-- Base de datos para el Sistema de Solicitudes de Servicios Industriales
-- ID Industrial

CREATE DATABASE IF NOT EXISTS id_industrial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE id_industrial;

-- Tabla de usuarios administradores
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'operator') DEFAULT 'operator',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    active TINYINT(1) DEFAULT 1
);

-- Tabla de solicitudes de servicios
CREATE TABLE IF NOT EXISTS service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_number VARCHAR(20) NOT NULL UNIQUE,
    company_name VARCHAR(200) NOT NULL,
    contact_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    service_type ENUM('mantenimiento', 'instalacion', 'consultoria', 'reparacion', 'otro') NOT NULL,
    service_description TEXT NOT NULL,
    priority ENUM('baja', 'media', 'alta', 'urgente') DEFAULT 'media',
    status ENUM('pendiente', 'en_proceso', 'completado', 'cancelado') DEFAULT 'pendiente',
    estimated_date DATE NULL,
    completion_date DATE NULL,
    notes TEXT NULL,
    admin_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    assigned_to INT NULL,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

-- Insertar usuario administrador por defecto
INSERT INTO users (username, email, password, full_name, role) VALUES 
('admin', 'admin@idindustrial.com.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador ID Industrial', 'admin');
-- Contraseña por defecto: password

-- Índices para mejorar rendimiento
CREATE INDEX idx_service_requests_status ON service_requests(status);
CREATE INDEX idx_service_requests_created ON service_requests(created_at);
CREATE INDEX idx_service_requests_number ON service_requests(request_number);