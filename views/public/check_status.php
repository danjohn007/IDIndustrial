<?php 
$title = 'Consultar Estado de Solicitud - ID Industrial';
ob_start(); 
?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="fas fa-search me-2"></i>
                    Consultar Estado de Solicitud
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Ingrese el número de su solicitud para consultar el estado actual del servicio.
                </p>

                <form method="GET" action="<?php echo BASE_URL; ?>check-status">
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3">
                            <label for="number" class="form-label">Número de Solicitud</label>
                            <input type="text" class="form-control" id="number" name="number" 
                                   value="<?php echo htmlspecialchars($request_number ?? ''); ?>" 
                                   placeholder="Ej: ID-2024-0001" required>
                            <div class="form-text">El número se encuentra en el email de confirmación</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-search me-1"></i>
                                Consultar
                            </button>
                        </div>
                    </div>
                </form>

                <?php if (isset($error_message) && !empty($error_message)): ?>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($request_data) && $request_data): ?>
                    <div class="card mt-4 border-success">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt text-success me-2"></i>
                                Información de la Solicitud
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary">Datos Generales</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td><strong>Número:</strong></td>
                                            <td><?php echo htmlspecialchars($request_data['request_number']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Empresa:</strong></td>
                                            <td><?php echo htmlspecialchars($request_data['company_name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tipo de Servicio:</strong></td>
                                            <td>
                                                <?php 
                                                $tipos = [
                                                    'mantenimiento' => 'Mantenimiento Industrial',
                                                    'instalacion' => 'Instalación de Equipos',
                                                    'reparacion' => 'Reparación de Maquinaria',
                                                    'consultoria' => 'Consultoría Técnica',
                                                    'otro' => 'Otro'
                                                ];
                                                echo $tipos[$request_data['service_type']] ?? ucfirst($request_data['service_type']);
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha de Solicitud:</strong></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($request_data['created_at'])); ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary">Estado Actual</h6>
                                    <div class="mb-3">
                                        <?php
                                        $status_classes = [
                                            'pendiente' => 'warning',
                                            'en_proceso' => 'info',
                                            'completado' => 'success',
                                            'cancelado' => 'danger'
                                        ];
                                        $status_icons = [
                                            'pendiente' => 'clock',
                                            'en_proceso' => 'cog fa-spin',
                                            'completado' => 'check-circle',
                                            'cancelado' => 'times-circle'
                                        ];
                                        $status_texts = [
                                            'pendiente' => 'Pendiente',
                                            'en_proceso' => 'En Proceso',
                                            'completado' => 'Completado',
                                            'cancelado' => 'Cancelado'
                                        ];
                                        
                                        $status = $request_data['status'];
                                        $class = $status_classes[$status] ?? 'secondary';
                                        $icon = $status_icons[$status] ?? 'question';
                                        $text = $status_texts[$status] ?? ucfirst($status);
                                        ?>
                                        <span class="badge bg-<?php echo $class; ?> fs-6">
                                            <i class="fas fa-<?php echo $icon; ?> me-1"></i>
                                            <?php echo $text; ?>
                                        </span>
                                    </div>
                                    
                                    <?php if (!empty($request_data['estimated_date'])): ?>
                                        <p class="mb-2">
                                            <strong>Fecha Estimada:</strong><br>
                                            <i class="fas fa-calendar-alt text-info me-1"></i>
                                            <?php echo date('d/m/Y', strtotime($request_data['estimated_date'])); ?>
                                        </p>
                                    <?php endif; ?>

                                    <!-- Progreso visual -->
                                    <div class="mt-3">
                                        <h6 class="text-primary mb-2">Progreso</h6>
                                        <?php
                                        $progress_steps = [
                                            'pendiente' => 25,
                                            'en_proceso' => 75,
                                            'completado' => 100,
                                            'cancelado' => 0
                                        ];
                                        $progress = $progress_steps[$status] ?? 0;
                                        ?>
                                        <div class="progress">
                                            <div class="progress-bar bg-<?php echo $class; ?>" 
                                                 style="width: <?php echo $progress; ?>%">
                                                <?php echo $progress; ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    ¿No Encuentra su Solicitud?
                </h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i> Verifique que el número sea correcto</li>
                    <li><i class="fas fa-check text-success me-2"></i> Revise su email de confirmación</li>
                    <li><i class="fas fa-check text-success me-2"></i> Contacte nuestro soporte si persiste el problema</li>
                </ul>
                <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-primary">
                    <i class="fas fa-plus me-1"></i>
                    Nueva Solicitud
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>