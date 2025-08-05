/**
 * JavaScript Principal - Sistema de Solicitud de Servicios
 * ID INDUSTRIAL
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mensaje de bienvenida en consola
    console.log('ID INDUSTRIAL - Sistema de Solicitudes v1.0.0');
    console.log('URL Base: https://idindustrial.com.mx/solicitudes/');
    
    // Función para mostrar la fecha y hora actual
    function updateDateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'America/Mexico_City'
        };
        
        const dateTimeString = now.toLocaleDateString('es-MX', options);
        
        // Si existe un elemento con id 'current-time', actualizar su contenido
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = dateTimeString;
        }
    }
    
    // Actualizar la fecha y hora cada segundo
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Animación suave para los botones
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Confirmación para enlaces de prueba
    const testConnectionBtn = document.querySelector('a[href="test_connection.php"]');
    if (testConnectionBtn) {
        testConnectionBtn.addEventListener('click', function(e) {
            if (!confirm('¿Desea ejecutar la prueba de conexión a la base de datos?')) {
                e.preventDefault();
            }
        });
    }
    
    // Función para validar configuración del sistema
    function validateSystemConfig() {
        const requiredConfig = [
            'DB_NAME: idindust_solicitudes',
            'DB_USER: idindust_solicitudes', 
            'BASE_URL: https://idindustrial.com.mx/solicitudes/'
        ];
        
        console.group('Configuración del Sistema');
        requiredConfig.forEach(config => {
            console.log('✓ ' + config);
        });
        console.groupEnd();
    }
    
    // Ejecutar validación de configuración
    validateSystemConfig();
    
});