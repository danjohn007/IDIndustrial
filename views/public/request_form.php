<?php 
$title = 'Solicitar Servicio Industrial - ID Industrial';
ob_start(); 
?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Solicitud de Servicio Industrial
                </h4>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Complete el siguiente formulario para solicitar un servicio industrial. 
                    Nos pondremos en contacto con usted a la brevedad.
                </p>

                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h6>Se encontraron los siguientes errores:</h6>
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo BASE_URL; ?>submit-request">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="company_name" class="form-label">Nombre de la Empresa *</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" 
                                   value="<?php echo htmlspecialchars($_POST['company_name'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_name" class="form-label">Nombre del Contacto *</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" 
                                   value="<?php echo htmlspecialchars($_POST['contact_name'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_email" class="form-label">Email de Contacto *</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                   value="<?php echo htmlspecialchars($_POST['contact_email'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_phone" class="form-label">Teléfono de Contacto *</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                                   value="<?php echo htmlspecialchars($_POST['contact_phone'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Tipo de Servicio *</label>
                            <select class="form-select" id="service_type" name="service_type" required>
                                <option value="">Seleccione un tipo de servicio</option>
                                <option value="mantenimiento" <?php echo ($_POST['service_type'] ?? '') === 'mantenimiento' ? 'selected' : ''; ?>>
                                    Mantenimiento Industrial
                                </option>
                                <option value="instalacion" <?php echo ($_POST['service_type'] ?? '') === 'instalacion' ? 'selected' : ''; ?>>
                                    Instalación de Equipos
                                </option>
                                <option value="reparacion" <?php echo ($_POST['service_type'] ?? '') === 'reparacion' ? 'selected' : ''; ?>>
                                    Reparación de Maquinaria
                                </option>
                                <option value="consultoria" <?php echo ($_POST['service_type'] ?? '') === 'consultoria' ? 'selected' : ''; ?>>
                                    Consultoría Técnica
                                </option>
                                <option value="otro" <?php echo ($_POST['service_type'] ?? '') === 'otro' ? 'selected' : ''; ?>>
                                    Otro
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Prioridad</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="baja" <?php echo ($_POST['priority'] ?? '') === 'baja' ? 'selected' : ''; ?>>Baja</option>
                                <option value="media" <?php echo ($_POST['priority'] ?? 'media') === 'media' ? 'selected' : ''; ?>>Media</option>
                                <option value="alta" <?php echo ($_POST['priority'] ?? '') === 'alta' ? 'selected' : ''; ?>>Alta</option>
                                <option value="urgente" <?php echo ($_POST['priority'] ?? '') === 'urgente' ? 'selected' : ''; ?>>Urgente</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="service_description" class="form-label">Descripción del Servicio *</label>
                        <textarea class="form-control" id="service_description" name="service_description" 
                                  rows="4" required placeholder="Describa detalladamente el servicio que requiere..."><?php echo htmlspecialchars($_POST['service_description'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notas Adicionales</label>
                        <textarea class="form-control" id="notes" name="notes" 
                                  rows="3" placeholder="Información adicional que considere relevante..."><?php echo htmlspecialchars($_POST['notes'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-undo me-1"></i>
                            Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información de contacto -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Información de Contacto
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="fas fa-globe me-2 text-primary"></i> 
                           <strong>Sitio Web:</strong> 
                           <a href="https://idindustrial.com.mx" target="_blank">idindustrial.com.mx</a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-clock me-2 text-primary"></i> 
                           <strong>Horario de Atención:</strong> Lun-Vie 8:00-18:00
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
include __DIR__ . '/../layouts/main.php';
?>