<?php
/**
 * Página Principal
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once 'config/config.php';
require_once 'classes/Database.php';

// Iniciar sesión
session_name(SESSION_NAME);
session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo APP_NAME; ?></h1>
            <p>Sistema de Solicitud de Servicios Industriales</p>
        </div>
    </header>

    <main>
        <div class="container">
            <section class="welcome">
                <h2>Bienvenido al Sistema de Solicitudes</h2>
                <p>Gestione sus solicitudes de servicios industriales de manera eficiente.</p>
                
                <div class="system-info">
                    <h3>Información del Sistema</h3>
                    <ul>
                        <li><strong>Versión:</strong> <?php echo APP_VERSION; ?></li>
                        <li><strong>URL Base:</strong> <?php echo BASE_URL; ?></li>
                        <li><strong>Zona Horaria:</strong> <?php echo APP_TIMEZONE; ?></li>
                    </ul>
                </div>

                <div class="actions">
                    <a href="test_connection.php" class="btn btn-primary">Probar Conexión BD</a>
                    <a href="#" class="btn btn-secondary">Nueva Solicitud</a>
                    <a href="#" class="btn btn-secondary">Ver Solicitudes</a>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> ID INDUSTRIAL. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>