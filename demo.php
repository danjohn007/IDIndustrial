<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID INDUSTRIAL - Sistema de Solicitud de Servicios</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        
        .header-section {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .demo-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .btn-demo {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 10px;
            padding: 15px 30px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-demo:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
            color: white;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list i {
            color: #28a745;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-industry me-3"></i>ID INDUSTRIAL</h1>
                    <p class="mb-0">Sistema de Solicitud de Servicios Industriales</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-success">Sistema Implementado</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="demo-card">
                    <h2><i class="fas fa-rocket me-2"></i>Sistema Completamente Implementado</h2>
                    <p class="lead">El sistema de solicitud de servicios industriales ha sido implementado con todas las características solicitadas.</p>
                    
                    <h4>Características Implementadas:</h4>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> <strong>Formulario elegante en PHP puro</strong> para solicitud de servicios</li>
                        <li><i class="fas fa-check"></i> <strong>Arquitectura MVC completa</strong> (Models, Views, Controllers)</li>
                        <li><i class="fas fa-check"></i> <strong>Admin dashboard</strong> con diseño Bootstrap y sidebar overlay</li>
                        <li><i class="fas fa-check"></i> <strong>Sistema de autenticación</strong> con roles (admin, técnico, cliente)</li>
                        <li><i class="fas fa-check"></i> <strong>Asignación de técnicos</strong> a cada solicitud</li>
                        <li><i class="fas fa-check"></i> <strong>Gestión de estatus y costos</strong> de servicios</li>
                        <li><i class="fas fa-check"></i> <strong>Listado de últimos servicios</strong> con filtros avanzados</li>
                        <li><i class="fas fa-check"></i> <strong>4 gráficas interactivas</strong> (estados, técnicos, ingresos, tipos de servicio)</li>
                        <li><i class="fas fa-check"></i> <strong>Total global de servicios</strong> con filtros por fecha, técnico, estatus y servicio</li>
                        <li><i class="fas fa-check"></i> <strong>Diseño responsive</strong> y moderno</li>
                        <li><i class="fas fa-check"></i> <strong>Exportación a CSV</strong> de reportes</li>
                        <li><i class="fas fa-check"></i> <strong>Base de datos MySQL</strong> con schema completo</li>
                    </ul>
                </div>
                
                <div class="demo-card">
                    <h3><i class="fas fa-database me-2"></i>Configuración de Base de Datos</h3>
                    <p>El sistema está configurado para usar:</p>
                    <ul>
                        <li><strong>Base de Datos:</strong> idindust_solicitudes</li>
                        <li><strong>Usuario:</strong> idindust_solicitudes</li>
                        <li><strong>Contraseña:</strong> Danjohn007</li>
                        <li><strong>URL Base:</strong> https://idindustrial.com.mx/admin/</li>
                    </ul>
                    <p>Para activar el sistema:</p>
                    <ol>
                        <li>Crear la base de datos MySQL</li>
                        <li>Ejecutar el script <code>database/schema.sql</code></li>
                        <li>Configurar el servidor web</li>
                    </ol>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="demo-card">
                    <h4><i class="fas fa-file-code me-2"></i>Archivos del Sistema</h4>
                    <div style="font-size: 0.875rem;">
                        <strong>Estructura MVC:</strong><br>
                        ├── config/<br>
                        │   ├── database.php<br>
                        │   └── config.php<br>
                        ├── controllers/<br>
                        │   ├── AuthController.php<br>
                        │   ├── DashboardController.php<br>
                        │   └── SolicitudController.php<br>
                        ├── models/<br>
                        │   ├── Solicitud.php<br>
                        │   └── Usuario.php<br>
                        ├── views/<br>
                        │   ├── auth/login.php<br>
                        │   ├── dashboard/index.php<br>
                        │   └── solicitud/form.php<br>
                        ├── public/<br>
                        │   ├── index.php<br>
                        │   ├── dashboard.php<br>
                        │   ├── login.php<br>
                        │   ├── logout.php<br>
                        │   └── api_ingresos.php<br>
                        └── database/<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;└── schema.sql
                    </div>
                </div>
                
                <div class="demo-card">
                    <h4><i class="fas fa-tools me-2"></i>Tecnologías</h4>
                    <ul class="feature-list">
                        <li><i class="fas fa-code"></i> PHP 8.3+ (POO, PDO)</li>
                        <li><i class="fas fa-database"></i> MySQL 5.7+</li>
                        <li><i class="fas fa-paint-brush"></i> Bootstrap 5.3</li>
                        <li><i class="fas fa-chart-bar"></i> Chart.js 4.2</li>
                        <li><i class="fas fa-icons"></i> Font Awesome 6.4</li>
                        <li><i class="fas fa-mobile-alt"></i> Responsive Design</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="demo-card text-center">
                    <h3><i class="fas fa-info-circle me-2"></i>Estado del Sistema</h3>
                    <p>El sistema está completamente implementado según las especificaciones. Para activar:</p>
                    <div class="alert alert-info">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Nota:</strong> Se requiere configuración de base de datos MySQL para funcionamiento completo.
                        Ejecute el script <code>database/schema.sql</code> para crear las tablas necesarias.
                    </div>
                    
                    <p class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        Sistema implementado el <?php echo date('d/m/Y H:i'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>