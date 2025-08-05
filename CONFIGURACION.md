# Sistema de Solicitud de Servicios - ID INDUSTRIAL

## Configuración del Sistema

El sistema ha sido configurado con los siguientes parámetros de conexión:

### Base de Datos
- **Base de Datos:** idindust_solicitudes
- **Usuario:** idindust_solicitudes  
- **Contraseña:** Danjohn007
- **Host:** localhost
- **Charset:** utf8mb4

### Aplicación
- **URL Base:** https://idindustrial.com.mx/solicitudes/
- **Nombre:** ID INDUSTRIAL - Sistema de Solicitudes
- **Versión:** 1.0.0
- **Zona Horaria:** America/Mexico_City

## Estructura de Archivos

```
IDIndustrial/
├── config/
│   ├── database.php      # Configuración de base de datos
│   └── config.php        # Configuración general
├── classes/
│   └── Database.php      # Clase de conexión PDO
├── assets/
│   ├── css/
│   │   └── style.css     # Estilos CSS
│   └── js/
│       └── main.js       # JavaScript
├── database/
│   └── schema.sql        # Estructura de base de datos
├── uploads/              # Directorio para archivos
├── index.php             # Página principal
├── test_connection.php   # Prueba de conexión
├── .htaccess            # Configuración Apache
└── .gitignore           # Archivos a ignorar

```

## Funcionalidades

### 1. Configuración de Base de Datos
- Archivo `config/database.php` con parámetros de conexión
- Clase `Database.php` con patrón Singleton para gestión de conexiones
- Soporte para transacciones y consultas preparadas

### 2. Estructura Web
- Página principal responsive con información del sistema
- CSS moderno con diseño industrial
- JavaScript para interactividad básica

### 3. Seguridad
- Configuración Apache con .htaccess
- Protección de archivos sensibles
- HTTPS forzado en producción

### 4. Base de Datos
- Schema SQL completo para gestión de solicitudes
- Tablas: usuarios, tipos_servicio, solicitudes, archivos_adjuntos, comentarios
- Índices optimizados para consultas

## Instalación

1. **Configurar el servidor web** apuntando a la URL base configurada
2. **Crear la base de datos** `idindust_solicitudes`
3. **Ejecutar el script** `database/schema.sql` para crear las tablas
4. **Configurar el usuario** de base de datos con los credenciales especificados
5. **Verificar la conexión** visitando `test_connection.php`

## Pruebas

Para verificar que la configuración es correcta:

1. Acceder a la página principal: `https://idindustrial.com.mx/solicitudes/`
2. Ejecutar la prueba de conexión: `https://idindustrial.com.mx/solicitudes/test_connection.php`

## Tecnologías Utilizadas

- **PHP 7.4+** con PDO para base de datos
- **MySQL/MariaDB** como motor de base de datos
- **HTML5/CSS3** para la interfaz web
- **JavaScript** para funcionalidades del cliente
- **Apache** como servidor web (configurado con .htaccess)

El sistema está listo para ser desplegado en el servidor de producción con la configuración especificada.