<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Overlay */
        .sidebar {
            position: fixed;
            top: 0;
            left: -var(--sidebar-width);
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--secondary-color) 0%, #34495e 100%);
            z-index: 1050;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar.active {
            left: 0;
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        
        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .sidebar-header .company-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-size: 1.5rem;
            color: white;
        }
        
        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .sidebar-nav .nav-link.active {
            background: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .sidebar-nav .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        
        .sidebar-user {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        .sidebar-user .user-info {
            color: white;
            font-size: 0.875rem;
        }
        
        .sidebar-user .user-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .sidebar-user .user-role {
            opacity: 0.7;
            text-transform: capitalize;
        }
        
        /* Main Content */
        .main-content {
            padding: 0;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        /* Top Navigation */
        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--secondary-color) !important;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--secondary-color);
            padding: 0.5rem;
            margin-right: 1rem;
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }
        
        .stat-card .icon.primary { background: linear-gradient(135deg, var(--primary-color), #2980b9); }
        .stat-card .icon.success { background: linear-gradient(135deg, var(--success-color), #1e7e34); }
        .stat-card .icon.warning { background: linear-gradient(135deg, var(--warning-color), #e0a800); }
        .stat-card .icon.danger { background: linear-gradient(135deg, var(--danger-color), #bd2130); }
        .stat-card .icon.info { background: linear-gradient(135deg, var(--info-color), #117a8b); }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Chart Cards */
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            height: 400px;
        }
        
        .chart-card h5 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .chart-container {
            position: relative;
            height: 320px;
        }
        
        /* Filters */
        .filters-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        /* Recent Services Table */
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .table-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            padding: 1rem 1.5rem;
            border: none;
            font-weight: 600;
        }
        
        .table-responsive {
            border-radius: 0 0 15px 15px;
        }
        
        .table th {
            background: #f8f9fa;
            color: var(--secondary-color);
            font-weight: 600;
            border: none;
            padding: 1rem;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        /* Status Badges */
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pendiente { background-color: #fff3cd; color: #856404; }
        .status-asignada { background-color: #d1ecf1; color: #0c5460; }
        .status-en_proceso { background-color: #cce5ff; color: #004085; }
        .status-completada { background-color: #d4edda; color: #155724; }
        .status-cancelada { background-color: #f8d7da; color: #721c24; }
        
        /* Priority Badges */
        .priority-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .priority-baja { background-color: #e2e3e5; color: #495057; }
        .priority-media { background-color: #fff3cd; color: #856404; }
        .priority-alta { background-color: #f8d7da; color: #721c24; }
        .priority-urgente { background-color: #f5c6cb; color: #491217; font-weight: 600; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100vw;
                left: -100vw;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .chart-card {
                height: auto;
                padding: 1rem;
            }
            
            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="company-icon">
                <i class="fas fa-industry"></i>
            </div>
            <h4>ID INDUSTRIAL</h4>
        </div>
        
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="dashboard.php?view=solicitudes" class="nav-link">
                <i class="fas fa-clipboard-list"></i>
                Solicitudes
            </a>
            <a href="dashboard.php?view=tecnicos" class="nav-link">
                <i class="fas fa-users-cog"></i>
                Técnicos
            </a>
            <a href="dashboard.php?view=reportes" class="nav-link">
                <i class="fas fa-chart-bar"></i>
                Reportes
            </a>
            <a href="dashboard.php?view=configuracion" class="nav-link">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
        </nav>
        
        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars($currentUser['nombre']); ?></div>
                <div class="user-role"><?php echo htmlspecialchars($currentUser['rol']); ?></div>
            </div>
            <a href="logout.php" class="btn btn-outline-light btn-sm mt-2 w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg top-navbar">
            <div class="container-fluid">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <span class="navbar-brand">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrativo
                </span>
                
                <div class="ms-auto">
                    <span class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        <?php echo date('d/m/Y H:i'); ?>
                    </span>
                </div>
            </div>
        </nav>
        
        <!-- Content -->
        <div class="container-fluid">
            <!-- Filters -->
            <div class="filters-card">
                <form method="GET" action="dashboard.php">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" 
                                   value="<?php echo $filters['fecha_desde']; ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" 
                                   value="<?php echo $filters['fecha_hasta']; ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Técnico</label>
                            <select class="form-select" name="tecnico_id">
                                <option value="">Todos</option>
                                <?php foreach ($tecnicos as $tecnico): ?>
                                    <option value="<?php echo $tecnico['id']; ?>" 
                                            <?php echo ($filters['tecnico_id'] == $tecnico['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tecnico['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado">
                                <option value="">Todos</option>
                                <option value="pendiente" <?php echo ($filters['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="asignada" <?php echo ($filters['estado'] == 'asignada') ? 'selected' : ''; ?>>Asignada</option>
                                <option value="en_proceso" <?php echo ($filters['estado'] == 'en_proceso') ? 'selected' : ''; ?>>En Proceso</option>
                                <option value="completada" <?php echo ($filters['estado'] == 'completada') ? 'selected' : ''; ?>>Completada</option>
                                <option value="cancelada" <?php echo ($filters['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipo Servicio</label>
                            <select class="form-select" name="tipo_servicio_id">
                                <option value="">Todos</option>
                                <?php foreach ($tiposServicio as $tipo): ?>
                                    <option value="<?php echo $tipo['id']; ?>" 
                                            <?php echo ($filters['tipo_servicio_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="icon primary">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="number"><?php echo number_format($estadisticas['total']); ?></div>
                        <div class="label">Total Solicitudes</div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="icon success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="number">$<?php echo number_format($estadisticas['total_ingresos'], 0); ?></div>
                        <div class="label">Ingresos Totales</div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="icon warning">
                            <?php 
                            $pendientes = 0;
                            foreach ($estadisticas['por_estado'] as $estado) {
                                if ($estado['estado'] == 'pendiente') {
                                    $pendientes = $estado['cantidad'];
                                    break;
                                }
                            }
                            ?>
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="number"><?php echo $pendientes; ?></div>
                        <div class="label">Pendientes</div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="icon info">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="number"><?php echo count($tecnicos); ?></div>
                        <div class="label">Técnicos Activos</div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="row mb-4">
                <!-- Chart 1: Estados -->
                <div class="col-xl-6 col-lg-6">
                    <div class="chart-card">
                        <h5><i class="fas fa-chart-pie me-2"></i>Solicitudes por Estado</h5>
                        <div class="chart-container">
                            <canvas id="chartEstados"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Chart 2: Técnicos -->
                <div class="col-xl-6 col-lg-6">
                    <div class="chart-card">
                        <h5><i class="fas fa-chart-bar me-2"></i>Productividad por Técnico</h5>
                        <div class="chart-container">
                            <canvas id="chartTecnicos"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <!-- Chart 3: Ingresos -->
                <div class="col-xl-6 col-lg-6">
                    <div class="chart-card">
                        <h5><i class="fas fa-chart-line me-2"></i>Ingresos Mensuales</h5>
                        <div class="chart-container">
                            <canvas id="chartIngresos"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Chart 4: Tipos de Servicio -->
                <div class="col-xl-6 col-lg-6">
                    <div class="chart-card">
                        <h5><i class="fas fa-chart-doughnut me-2"></i>Tipos de Servicio</h5>
                        <div class="chart-container">
                            <canvas id="chartTiposServicio"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Services Table -->
            <div class="table-card">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Últimos Servicios
                    <a href="dashboard.php?export=csv&<?php echo http_build_query($filters); ?>" 
                       class="btn btn-outline-light btn-sm float-end">
                        <i class="fas fa-download me-2"></i>Exportar CSV
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servicio</th>
                                <th>Técnico</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                <th>Costo</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($solicitudesRecientes as $solicitud): ?>
                            <tr>
                                <td><strong>#<?php echo $solicitud['id']; ?></strong></td>
                                <td>
                                    <div>
                                        <strong><?php echo htmlspecialchars($solicitud['cliente_nombre']); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($solicitud['cliente_empresa'] ?? ''); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?php echo htmlspecialchars($solicitud['titulo']); ?>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($solicitud['tipo_servicio_nombre']); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($solicitud['tecnico_nombre']): ?>
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($solicitud['tecnico_nombre']); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">Sin asignar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $solicitud['estado']; ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $solicitud['estado'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="priority-badge priority-<?php echo $solicitud['prioridad']; ?>">
                                        <?php echo ucfirst($solicitud['prioridad']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($solicitud['costo_final']): ?>
                                        <strong>$<?php echo number_format($solicitud['costo_final'], 2); ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?php echo date('d/m/Y', strtotime($solicitud['fecha_creacion'])); ?></small>
                                </td>
                                <td>
                                    <a href="dashboard.php?view=solicitud&id=<?php echo $solicitud['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            }
            
            menuToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });
        
        // Charts Data
        const chartEstados = <?php echo json_encode($graficoEstados); ?>;
        const chartTecnicos = <?php echo json_encode($graficoTecnicos); ?>;
        const chartIngresos = <?php echo json_encode($graficoIngresos); ?>;
        const chartTiposServicio = <?php echo json_encode($graficoTiposServicio); ?>;
        
        // Chart 1: Estados (Pie Chart)
        const ctx1 = document.getElementById('chartEstados').getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: chartEstados.labels,
                datasets: [{
                    data: chartEstados.data,
                    backgroundColor: chartEstados.colors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Chart 2: Técnicos (Bar Chart)
        const ctx2 = document.getElementById('chartTecnicos').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: chartTecnicos.labels,
                datasets: [{
                    label: 'Solicitudes Asignadas',
                    data: chartTecnicos.data,
                    backgroundColor: 'rgba(52, 152, 219, 0.8)',
                    borderColor: 'rgba(52, 152, 219, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Chart 3: Ingresos (Line Chart)
        const ctx3 = document.getElementById('chartIngresos').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: chartIngresos.labels,
                datasets: [{
                    label: 'Ingresos ($)',
                    data: chartIngresos.data,
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        // Chart 4: Tipos de Servicio (Doughnut Chart)
        const ctx4 = document.getElementById('chartTiposServicio').getContext('2d');
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: chartTiposServicio.labels,
                datasets: [{
                    data: chartTiposServicio.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Auto-refresh data every 5 minutes
        setInterval(function() {
            location.reload();
        }, 300000);
    </script>
</body>
</html>