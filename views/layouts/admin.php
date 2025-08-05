<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Panel Administrativo - ID Industrial'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .stats-card {
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 p-0">
                <div class="sidebar text-white p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-industry fa-2x mb-2"></i>
                        <h5 class="mb-0">ID Industrial</h5>
                        <small class="opacity-75">Panel Admin</small>
                    </div>

                    <nav class="nav flex-column">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>admin">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>admin/requests">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Solicitudes
                        </a>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>admin/users">
                            <i class="fas fa-users me-2"></i>
                            Usuarios
                        </a>
                        <?php endif; ?>
                        <hr class="my-3">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>admin/export-csv">
                            <i class="fas fa-download me-2"></i>
                            Exportar CSV
                        </a>
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">
                            <i class="fas fa-globe me-2"></i>
                            Sitio Público
                        </a>
                    </nav>

                    <div class="mt-auto pt-4">
                        <div class="text-center">
                            <div class="mb-2">
                                <i class="fas fa-user-circle fa-2x"></i>
                            </div>
                            <div class="small">
                                <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                                <br>
                                <span class="opacity-75"><?php echo ucfirst($_SESSION['role']); ?></span>
                            </div>
                            <a href="<?php echo BASE_URL; ?>admin/logout" class="btn btn-outline-light btn-sm mt-2">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Salir
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 p-0">
                <div class="main-content">
                    <!-- Top Navigation -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                        <div class="container-fluid">
                            <h5 class="navbar-brand mb-0">
                                <?php echo $page_title ?? 'Panel Administrativo'; ?>
                            </h5>
                            <div class="navbar-nav ms-auto">
                                <span class="navbar-text">
                                    <i class="fas fa-clock me-1"></i>
                                    <?php echo date('d/m/Y H:i'); ?>
                                </span>
                            </div>
                        </div>
                    </nav>

                    <!-- Page Content -->
                    <div class="container-fluid p-4">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php echo $content ?? ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activar enlace actual en sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href').includes(currentPath.split('/').pop())) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>