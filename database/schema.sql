-- Script de creación de base de datos
-- Sistema de Solicitud de Servicios - ID INDUSTRIAL
-- Base de datos: idindust_solicitudes

-- Usar la base de datos
USE idindust_solicitudes;

-- Tabla de usuarios del sistema
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    empresa VARCHAR(100),
    rol ENUM('admin', 'tecnico', 'cliente') DEFAULT 'cliente',
    activo TINYINT(1) DEFAULT 1,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de técnicos
CREATE TABLE IF NOT EXISTS tecnicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    especialidad VARCHAR(100),
    experiencia_años INT DEFAULT 0,
    certificaciones TEXT,
    activo TINYINT(1) DEFAULT 1,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de tipos de servicio
CREATE TABLE IF NOT EXISTS tipos_servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de solicitudes
CREATE TABLE IF NOT EXISTS solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo_servicio_id INT NOT NULL,
    tecnico_id INT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('baja', 'media', 'alta', 'urgente') DEFAULT 'media',
    estado ENUM('pendiente', 'asignada', 'en_proceso', 'completada', 'cancelada') DEFAULT 'pendiente',
    costo_estimado DECIMAL(10,2) NULL,
    costo_final DECIMAL(10,2) NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fecha_vencimiento DATE,
    fecha_asignacion TIMESTAMP NULL,
    fecha_inicio TIMESTAMP NULL,
    fecha_finalizacion TIMESTAMP NULL,
    observaciones TEXT,
    direccion_servicio TEXT,
    contacto_sitio VARCHAR(100),
    telefono_contacto VARCHAR(20),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tipo_servicio_id) REFERENCES tipos_servicio(id) ON DELETE RESTRICT,
    FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE SET NULL
);

-- Tabla de archivos adjuntos
CREATE TABLE IF NOT EXISTS archivos_adjuntos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    nombre_original VARCHAR(255) NOT NULL,
    tipo_mime VARCHAR(100),
    tamaño INT,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (solicitud_id) REFERENCES solicitudes(id) ON DELETE CASCADE
);

-- Tabla de comentarios/seguimiento
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (solicitud_id) REFERENCES solicitudes(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Insertar datos de ejemplo
INSERT INTO tipos_servicio (nombre, descripcion) VALUES
('Mantenimiento Preventivo', 'Servicios de mantenimiento preventivo de equipos industriales'),
('Mantenimiento Correctivo', 'Reparación de equipos y maquinaria industrial'),
('Instalación', 'Instalación de nuevos equipos y sistemas'),
('Capacitación', 'Servicios de capacitación técnica'),
('Consultoría', 'Servicios de consultoría especializada');

-- Insertar usuario administrador de ejemplo
INSERT INTO usuarios (nombre, email, password, telefono, empresa, rol) VALUES
('Administrador Sistema', 'admin@idindustrial.com.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0000', 'ID INDUSTRIAL', 'admin');

-- Insertar técnicos de ejemplo
INSERT INTO usuarios (nombre, email, password, telefono, empresa, rol) VALUES
('Juan Pérez', 'juan.perez@idindustrial.com.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0001', 'ID INDUSTRIAL', 'tecnico'),
('María García', 'maria.garcia@idindustrial.com.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0002', 'ID INDUSTRIAL', 'tecnico'),
('Carlos López', 'carlos.lopez@idindustrial.com.mx', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '555-0003', 'ID INDUSTRIAL', 'tecnico');

-- Insertar información de técnicos
INSERT INTO tecnicos (usuario_id, especialidad, experiencia_años, certificaciones) VALUES
(2, 'Mantenimiento Eléctrico', 5, 'Certificación en Sistemas Eléctricos Industriales'),
(3, 'Mantenimiento Mecánico', 7, 'Certificación en Soldadura y Mecanizado'),
(4, 'Automatización', 3, 'Certificación en PLC y SCADA');

-- Crear índices para optimizar consultas
CREATE INDEX idx_solicitudes_usuario ON solicitudes(usuario_id);
CREATE INDEX idx_solicitudes_estado ON solicitudes(estado);
CREATE INDEX idx_solicitudes_fecha ON solicitudes(fecha_creacion);
CREATE INDEX idx_solicitudes_tecnico ON solicitudes(tecnico_id);
CREATE INDEX idx_archivos_solicitud ON archivos_adjuntos(solicitud_id);
CREATE INDEX idx_comentarios_solicitud ON comentarios(solicitud_id);
CREATE INDEX idx_tecnicos_usuario ON tecnicos(usuario_id);