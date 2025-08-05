# Sistema de Solicitud de Servicios Industriales – ID INDUSTRIAL

Este proyecto es un sistema en PHP puro bajo estructura MVC para gestionar solicitudes de servicios industriales realizadas desde el sitio web de ID Industrial: https://idindustrial.com.mx/inicio.html

## ✨ Características

- ✅ Formulario público para registrar solicitudes
- ✅ Panel de administrador con autenticación
- ✅ Gestión de solicitudes (ver, editar estatus)
- ✅ Base de datos MySQL con conexión PDO
- ✅ Código limpio sin frameworks
- ✅ Diseño responsive con Bootstrap 5
- ✅ Sistema de autenticación seguro
- ✅ Exportación de datos a CSV
- ✅ Consulta pública de estado de solicitudes

## 🚀 Requisitos

- PHP 8.0 o superior
- Servidor Apache (recomendado)
- MySQL 5.7+
- Composer (opcional, si decides integrar librerías)

## 📁 Estructura del Proyecto

```
/solicitudes-industriales/
├── config/             # Configuración de la aplicación
│   ├── config.php      # Configuración general
│   └── database.php    # Configuración de base de datos
├── controllers/        # Controladores MVC
│   ├── AdminController.php
│   ├── AuthController.php
│   └── PublicController.php
├── models/            # Modelos de datos
│   ├── ServiceRequest.php
│   └── User.php
├── views/             # Vistas de la aplicación
│   ├── admin/         # Vistas del panel administrativo
│   ├── public/        # Vistas públicas
│   ├── layouts/       # Plantillas base
│   └── errors/        # Páginas de error
├── public/            # Punto de entrada web
│   └── index.php      # Archivo principal
├── routes/            # Sistema de enrutamiento
│   └── Router.php
├── helpers/           # Funciones auxiliares
│   └── Helper.php
├── assets/            # Recursos estáticos
│   ├── css/
│   └── js/
├── database/          # Scripts de base de datos
│   └── schema.sql     # Esquema de la base de datos
└── .htaccess         # Configuración de Apache
```

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/danjohn007/IDIndustrial.git
cd IDIndustrial
```

### 2. Configurar la base de datos
```bash
# Crear la base de datos MySQL
mysql -u root -p
CREATE DATABASE id_industrial CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit

# Importar el esquema
mysql -u root -p id_industrial < database/schema.sql
```

### 3. Configurar el servidor web

#### Apache
Asegúrate de que el módulo `mod_rewrite` esté activado:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Configura el DocumentRoot a la carpeta del proyecto o crea un Virtual Host:
```apache
<VirtualHost *:80>
    ServerName id-industrial.local
    DocumentRoot /ruta/a/tu/proyecto/IDIndustrial
    <Directory /ruta/a/tu/proyecto/IDIndustrial>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 4. Configurar la aplicación
Edita el archivo `config/database.php` con tus credenciales de base de datos:
```php
private $host = 'localhost';
private $db_name = 'id_industrial';
private $username = 'tu_usuario';
private $password = 'tu_contraseña';
```

Opcionalmente, ajusta la configuración en `config/config.php`:
```php
define('BASE_URL', 'http://tu-dominio.com/');
```

### 5. Permisos (Linux/macOS)
```bash
chmod -R 755 .
chmod -R 777 logs/ # Si existe el directorio de logs
```

## 🔑 Credenciales por defecto

- **Usuario**: admin
- **Email**: admin@idindustrial.com.mx
- **Contraseña**: password

⚠️ **¡IMPORTANTE!** Cambia estas credenciales inmediatamente después de la instalación.

## 📖 Uso

### Para usuarios públicos:
1. Visita la página principal del sitio
2. Completa el formulario de solicitud de servicio
3. Recibe un número de solicitud para seguimiento
4. Consulta el estado usando el número de solicitud

### Para administradores:
1. Accede a `/admin/login`
2. Inicia sesión con las credenciales de administrador
3. Gestiona solicitudes desde el panel de control
4. Actualiza estados, asigna técnicos y añade notas

## 🎨 Características Técnicas

- **Arquitectura**: MVC (Model-View-Controller)
- **Base de datos**: MySQL con PDO
- **Frontend**: Bootstrap 5 + Font Awesome
- **Seguridad**: Autenticación por sesiones, validación de datos
- **Responsive**: Compatible con móviles y tablets
- **SEO**: URLs amigables con mod_rewrite

## 🔧 Funcionalidades

### Panel Público:
- Formulario de solicitud de servicios
- Consulta de estado de solicitudes
- Interfaz responsive

### Panel Administrativo:
- Dashboard con estadísticas
- Lista y filtrado de solicitudes
- Edición de solicitudes
- Gestión de usuarios (solo admin)
- Exportación a CSV
- Sistema de asignación de técnicos

## 🔒 Seguridad

- Autenticación segura con hash de contraseñas
- Validación y sanitización de datos de entrada
- Protección contra inyección SQL con PDO
- Sesiones seguras con timeout
- Protección de directorios del sistema

## 📞 Soporte

Para soporte técnico, contacta:
- **Web**: [idindustrial.com.mx](https://idindustrial.com.mx)
- **Email**: admin@idindustrial.com.mx

## 📝 Licencia

Este proyecto está desarrollado para ID Industrial. Todos los derechos reservados.

---

**Desarrollado con ❤️ para ID Industrial**
