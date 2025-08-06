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
        
        // Probar una consulta simple
        $result = $db->fetchOne("SELECT NOW() as current_time, DATABASE() as database_name, CURRENT_USER() as current_user");
        
        if ($result) {
            echo "<h4>Información de la Conexión:</h4>\n";
            echo "<ul>\n";
            echo "<li><strong>Tiempo del Servidor:</strong> " . $result['current_time'] . "</li>\n";
            echo "<li><strong>Base de Datos Activa:</strong> " . $result['database_name'] . "</li>\n";
            echo "<li><strong>Usuario Conectado:</strong> " . $result['current_user'] . "</li>\n";
            echo "</ul>\n";
        }
        
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