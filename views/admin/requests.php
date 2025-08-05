<?php 
$title = 'Gestión de Solicitudes - Panel Administrativo';
$page_title = 'Gestión de Solicitudes';
ob_start(); 
?>

<!-- Filters and Search -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="GET" action="<?php echo BASE_URL; ?>admin/requests" class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Filtrar por Estado</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" <?php echo ($_GET['status'] ?? '') === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="en_proceso" <?php echo ($_GET['status'] ?? '') === 'en_proceso' ? 'selected' : ''; ?>>En Proceso</option>
                            <option value="completado" <?php echo ($_GET['status'] ?? '') === 'completado' ? 'selected' : ''; ?>>Completado</option>
                            <option value="cancelado" <?php echo ($_GET['status'] ?? '') === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" 
                               placeholder="Número, empresa o contacto...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Requests Table -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lista de Solicitudes (<?php echo count($requests); ?>)
                </h5>
                <div>
                    <a href="<?php echo BASE_URL; ?>admin/export-csv" class="btn btn-success btn-sm">
                        <i class="fas fa-download me-1"></i>
                        Exportar CSV
                    </a>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-plus me-1"></i>
                        Nueva Solicitud
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($requests)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Empresa</th>
                                    <th>Contacto</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Prioridad</th>
                                    <th>Fecha</th>
                                    <th>Asignado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $request): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary"><?php echo htmlspecialchars($request['request_number']); ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($request['company_name']); ?></strong>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($request['contact_name']); ?><br>
                                            <small class="text-muted">
                                                <i class="fas fa-envelope me-1"></i>
                                                <?php echo htmlspecialchars($request['contact_email']); ?>
                                            </small>
                                        </td>
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
                                        <td>
                                            <?php
                                            $priority_classes = [
                                                'baja' => 'secondary',
                                                'media' => 'info',
                                                'alta' => 'warning',
                                                'urgente' => 'danger'
                                            ];
                                            $priority_texts = [
                                                'baja' => 'Baja',
                                                'media' => 'Media',
                                                'alta' => 'Alta',
                                                'urgente' => 'Urgente'
                                            ];
                                            $class = $priority_classes[$request['priority']] ?? 'secondary';
                                            $text = $priority_texts[$request['priority']] ?? ucfirst($request['priority']);
                                            ?>
                                            <span class="badge bg-<?php echo $class; ?>"><?php echo $text; ?></span>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y', strtotime($request['created_at'])); ?><br>
                                            <small class="text-muted"><?php echo date('H:i', strtotime($request['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <?php if ($request['assigned_user']): ?>
                                                <span class="badge bg-info"><?php echo htmlspecialchars($request['assigned_user']); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">Sin asignar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo BASE_URL; ?>admin/request?id=<?php echo $request['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#quickUpdateModal" 
                                                        data-id="<?php echo $request['id']; ?>"
                                                        data-status="<?php echo $request['status']; ?>"
                                                        data-priority="<?php echo $request['priority']; ?>"
                                                        title="Edición rápida">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No se encontraron solicitudes</h5>
                        <p class="text-muted">
                            <?php if (!empty($_GET['search']) || !empty($_GET['status'])): ?>
                                Intente ajustar los filtros de búsqueda
                            <?php else: ?>
                                Aún no hay solicitudes registradas en el sistema
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo BASE_URL; ?>admin/requests" class="btn btn-primary">
                            <i class="fas fa-refresh me-1"></i>
                            Limpiar Filtros
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Update Modal -->
<div class="modal fade" id="quickUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualización Rápida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>admin/update-request">
                <div class="modal-body">
                    <input type="hidden" id="modal_request_id" name="id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_status" class="form-label">Estado</label>
                            <select class="form-select" id="modal_status" name="status">
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal_priority" class="form-label">Prioridad</label>
                            <select class="form-select" id="modal_priority" name="priority">
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modal_assigned_to" class="form-label">Asignar a</label>
                        <select class="form-select" id="modal_assigned_to" name="assigned_to">
                            <option value="">Sin asignar</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Manejo del modal de actualización rápida
document.addEventListener('DOMContentLoaded', function() {
    const quickUpdateModal = document.getElementById('quickUpdateModal');
    if (quickUpdateModal) {
        quickUpdateModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const status = button.getAttribute('data-status');
            const priority = button.getAttribute('data-priority');
            
            document.getElementById('modal_request_id').value = id;
            document.getElementById('modal_status').value = status;
            document.getElementById('modal_priority').value = priority;
        });
    }
});
</script>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>