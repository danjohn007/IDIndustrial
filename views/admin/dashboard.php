<?php 
$title = 'Dashboard - Panel Administrativo';
$page_title = 'Dashboard Principal';
ob_start(); 
?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-primary text-uppercase mb-1">Total Solicitudes</h6>
                        <h4 class="mb-0"><?php echo $statistics['total'] ?? 0; ?></h4>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-warning text-uppercase mb-1">Pendientes</h6>
                        <h4 class="mb-0"><?php echo $statistics['pendientes'] ?? 0; ?></h4>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-info text-uppercase mb-1">En Proceso</h6>
                        <h4 class="mb-0"><?php echo $statistics['en_proceso'] ?? 0; ?></h4>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-cog fa-spin fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-success text-uppercase mb-1">Completadas</h6>
                        <h4 class="mb-0"><?php echo $statistics['completadas'] ?? 0; ?></h4>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-rocket me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>admin/requests" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>
                            Ver Todas las Solicitudes
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>admin/requests?status=pendiente" class="btn btn-outline-warning w-100">
                            <i class="fas fa-clock me-2"></i>
                            Solicitudes Pendientes
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>admin/export-csv" class="btn btn-outline-success w-100">
                            <i class="fas fa-download me-2"></i>
                            Exportar Datos
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-info w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Sitio Público
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Requests -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Solicitudes Recientes
                </h5>
                <a href="<?php echo BASE_URL; ?>admin/requests" class="btn btn-sm btn-primary">
                    Ver Todas
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_requests)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Empresa</th>
                                    <th>Tipo de Servicio</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_requests as $request): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary"><?php echo htmlspecialchars($request['request_number']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($request['company_name']); ?></td>
                                        <td>
                                            <?php 
                                            $tipos = [
                                                'mantenimiento' => 'Mantenimiento',
                                                'instalacion' => 'Instalación',
                                                'reparacion' => 'Reparación',
                                                'consultoria' => 'Consultoría',
                                                'otro' => 'Otro'
                                            ];
                                            echo $tipos[$request['service_type']] ?? ucfirst($request['service_type']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status_classes = [
                                                'pendiente' => 'warning',
                                                'en_proceso' => 'info',
                                                'completado' => 'success',
                                                'cancelado' => 'danger'
                                            ];
                                            $status_texts = [
                                                'pendiente' => 'Pendiente',
                                                'en_proceso' => 'En Proceso',
                                                'completado' => 'Completado',
                                                'cancelado' => 'Cancelado'
                                            ];
                                            $class = $status_classes[$request['status']] ?? 'secondary';
                                            $text = $status_texts[$request['status']] ?? ucfirst($request['status']);
                                            ?>
                                            <span class="badge bg-<?php echo $class; ?>"><?php echo $text; ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($request['created_at'])); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>admin/request?id=<?php echo $request['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay solicitudes recientes</p>
                        <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Ir al Formulario Público
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>