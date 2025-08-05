<?php 
$title = 'Detalle de Solicitud - Panel Administrativo';
$page_title = 'Detalle de Solicitud #' . $serviceRequest->request_number;
ob_start(); 
?>

<div class="row">
    <div class="col-lg-8">
        <!-- Información Principal -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Información de la Solicitud
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Número:</strong></td>
                                <td><span class="badge bg-primary fs-6"><?php echo htmlspecialchars($serviceRequest->request_number); ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Empresa:</strong></td>
                                <td><?php echo htmlspecialchars($serviceRequest->company_name); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Contacto:</strong></td>
                                <td><?php echo htmlspecialchars($serviceRequest->contact_name); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($serviceRequest->contact_email); ?>">
                                        <?php echo htmlspecialchars($serviceRequest->contact_email); ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Teléfono:</strong></td>
                                <td>
                                    <a href="tel:<?php echo htmlspecialchars($serviceRequest->contact_phone); ?>">
                                        <?php echo htmlspecialchars($serviceRequest->contact_phone); ?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Tipo de Servicio:</strong></td>
                                <td><?php echo Helper::getServiceTypeText($serviceRequest->service_type); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Estado:</strong></td>
                                <td>
                                    <span class="badge bg-<?php echo Helper::getStatusClass($serviceRequest->status); ?>">
                                        <?php echo Helper::getStatusText($serviceRequest->status); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Prioridad:</strong></td>
                                <td>
                                    <span class="badge bg-<?php echo Helper::getPriorityClass($serviceRequest->priority); ?>">
                                        <?php echo Helper::getPriorityText($serviceRequest->priority); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Fecha de Creación:</strong></td>
                                <td><?php echo Helper::formatDate($serviceRequest->created_at); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Última Actualización:</strong></td>
                                <td><?php echo Helper::formatDate($serviceRequest->updated_at); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción del Servicio -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Descripción del Servicio
                </h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><?php echo nl2br(htmlspecialchars($serviceRequest->service_description)); ?></p>
                
                <?php if (!empty($serviceRequest->notes)): ?>
                    <h6 class="text-muted">Notas del Cliente:</h6>
                    <p class="text-muted"><?php echo nl2br(htmlspecialchars($serviceRequest->notes)); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notas Administrativas -->
        <?php if (!empty($serviceRequest->admin_notes)): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note me-2"></i>
                    Notas Administrativas
                </h5>
            </div>
            <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($serviceRequest->admin_notes)); ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <!-- Panel de Gestión -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Gestión de Solicitud
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo BASE_URL; ?>admin/update-request">
                    <input type="hidden" name="id" value="<?php echo $serviceRequest->id; ?>">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pendiente" <?php echo $serviceRequest->status === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="en_proceso" <?php echo $serviceRequest->status === 'en_proceso' ? 'selected' : ''; ?>>En Proceso</option>
                            <option value="completado" <?php echo $serviceRequest->status === 'completado' ? 'selected' : ''; ?>>Completado</option>
                            <option value="cancelado" <?php echo $serviceRequest->status === 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="baja" <?php echo $serviceRequest->priority === 'baja' ? 'selected' : ''; ?>>Baja</option>
                            <option value="media" <?php echo $serviceRequest->priority === 'media' ? 'selected' : ''; ?>>Media</option>
                            <option value="alta" <?php echo $serviceRequest->priority === 'alta' ? 'selected' : ''; ?>>Alta</option>
                            <option value="urgente" <?php echo $serviceRequest->priority === 'urgente' ? 'selected' : ''; ?>>Urgente</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Asignar a</label>
                        <select class="form-select" id="assigned_to" name="assigned_to">
                            <option value="">Sin asignar</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>" 
                                        <?php echo $serviceRequest->assigned_to == $user['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['full_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estimated_date" class="form-label">Fecha Estimada</label>
                        <input type="date" class="form-control" id="estimated_date" name="estimated_date" 
                               value="<?php echo $serviceRequest->estimated_date; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="completion_date" class="form-label">Fecha de Finalización</label>
                        <input type="date" class="form-control" id="completion_date" name="completion_date" 
                               value="<?php echo $serviceRequest->completion_date; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Notas Administrativas</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" 
                                  placeholder="Agregar notas internas..."><?php echo htmlspecialchars($serviceRequest->admin_notes); ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>
                            Actualizar Solicitud
                        </button>
                        <a href="<?php echo BASE_URL; ?>admin/requests" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Volver a la Lista
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Información Adicional
                </h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <div class="mb-2">
                        <strong>ID:</strong> <?php echo $serviceRequest->id; ?>
                    </div>
                    <div class="mb-2">
                        <strong>Creado:</strong> <?php echo Helper::formatDate($serviceRequest->created_at); ?>
                    </div>
                    <?php if ($serviceRequest->updated_at !== $serviceRequest->created_at): ?>
                    <div class="mb-2">
                        <strong>Modificado:</strong> <?php echo Helper::formatDate($serviceRequest->updated_at); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($serviceRequest->estimated_date)): ?>
                    <div class="mb-2">
                        <strong>Estimado:</strong> <?php echo Helper::formatDate($serviceRequest->estimated_date, 'd/m/Y'); ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($serviceRequest->completion_date)): ?>
                    <div class="mb-2">
                        <strong>Completado:</strong> <?php echo Helper::formatDate($serviceRequest->completion_date, 'd/m/Y'); ?>
                    </div>
                    <?php endif; ?>
                </small>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>