<?php
/**
 * Script de Prueba de Conexión a Base de Datos
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

// Incluir configuraciones
require_once 'config/config.php';
require_once 'classes/Database.php';

echo "<h2>Prueba de Conexión - ID INDUSTRIAL</h2>\n";
echo "<p>Sistema de Solicitud de Servicios</p>\n";
echo "<hr>\n";

// Mostrar configuración (sin la contraseña por seguridad)
echo "<h3>Configuración de Base de Datos:</h3>\n";
echo "<ul>\n";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>\n";
echo "<li><strong>Base de Datos:</strong> " . DB_NAME . "</li>\n";
echo "<li><strong>Usuario:</strong> " . DB_USER . "</li>\n";
echo "<li><strong>Charset:</strong> " . DB_CHARSET . "</li>\n";
echo "</ul>\n";

echo "<h3>Configuración de Aplicación:</h3>\n";
echo "<ul>\n";
echo "<li><strong>URL Base:</strong> " . BASE_URL . "</li>\n";
echo "<li><strong>Nombre de la App:</strong> " . APP_NAME . "</li>\n";
echo "<li><strong>Versión:</strong> " . APP_VERSION . "</li>\n";
echo "<li><strong>Zona Horaria:</strong> " . APP_TIMEZONE . "</li>\n";
echo "</ul>\n";

// Probar conexión
echo "<h3>Prueba de Conexión a Base de Datos:</h3>\n";

try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "<div style='color: green; font-weight: bold;'>✓ Conexión exitosa a la base de datos</div>\n";
        
        // Probar consultas individuales para mejor compatibilidad
        // Dividimos en consultas separadas para manejar posibles incompatibilidades
        // con diferentes versiones de MySQL/MariaDB o falta de privilegios
        echo "<h4>Información de la Conexión:</h4>\n";
        echo "<ul>\n";
        
        // Consulta 1: Obtener tiempo del servidor (NOW())
        try {
            $timeResult = $db->fetchOne("SELECT NOW() as current_time");
            if ($timeResult && isset($timeResult['current_time'])) {
                echo "<li><strong>Tiempo del Servidor:</strong> " . $timeResult['current_time'] . "</li>\n";
            } else {
                echo "<li><strong>Tiempo del Servidor:</strong> <em style='color: orange;'>No disponible</em></li>\n";
            }
        } catch (Exception $e) {
            echo "<li><strong>Tiempo del Servidor:</strong> <em style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</em></li>\n";
        }
        
        // Consulta 2: Obtener nombre de la base de datos (DATABASE())
        try {
            $dbResult = $db->fetchOne("SELECT DATABASE() as database_name");
            if ($dbResult && isset($dbResult['database_name'])) {
                echo "<li><strong>Base de Datos Activa:</strong> " . $dbResult['database_name'] . "</li>\n";
            } else {
                echo "<li><strong>Base de Datos Activa:</strong> <em style='color: orange;'>No disponible</em></li>\n";
            }
        } catch (Exception $e) {
            echo "<li><strong>Base de Datos Activa:</strong> <em style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</em></li>\n";
        }
        
        // Consulta 3: Obtener usuario actual (CURRENT_USER())
        try {
            $userResult = $db->fetchOne("SELECT CURRENT_USER() as current_user");
            if ($userResult && isset($userResult['current_user'])) {
                echo "<li><strong>Usuario Conectado:</strong> " . $userResult['current_user'] . "</li>\n";
            } else {
                echo "<li><strong>Usuario Conectado:</strong> <em style='color: orange;'>No disponible</em></li>\n";
            }
        } catch (Exception $e) {
            echo "<li><strong>Usuario Conectado:</strong> <em style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</em></li>\n";
        }
        
        echo "</ul>\n";
        
    } else {
        echo "<div style='color: red; font-weight: bold;'>✗ Error: No se pudo establecer la conexión</div>\n";
    }
    
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>✗ Error de conexión: " . $e->getMessage() . "</div>\n";
    echo "<p>Verifique los parámetros de conexión en config/database.php</p>\n";
}

echo "<hr>\n";
echo "<p><em>Prueba realizada el: " . date('Y-m-d H:i:s') . "</em></p>\n";

?>