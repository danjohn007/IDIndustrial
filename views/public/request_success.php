<?php 
$title = 'Solicitud Enviada Exitosamente - ID Industrial';
ob_start(); 
?>

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-check-circle me-2"></i>
                    Solicitud Enviada Exitosamente
                </h4>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                
                <h5 class="text-success mb-3">¡Su solicitud ha sido enviada correctamente!</h5>
                
                <div class="alert alert-info">
                    <h6 class="alert-heading">Número de Solicitud:</h6>
                    <h4 class="mb-0"><?php echo htmlspecialchars($success_message ?? 'N/A'); ?></h4>
                </div>

                <p class="text-muted mb-4">
                    Hemos recibido su solicitud de servicio industrial. Nuestro equipo revisará 
                    la información y se pondrá en contacto con usted en un plazo máximo de 24 horas.
                </p>

                <div class="row text-start">
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-clock me-2"></i>
                            Próximos Pasos:
                        </h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i> Revisión de solicitud</li>
                            <li><i class="fas fa-check text-success me-2"></i> Evaluación técnica</li>
                            <li><i class="fas fa-check text-success me-2"></i> Contacto con el cliente</li>
                            <li><i class="fas fa-check text-success me-2"></i> Programación del servicio</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">
                            <i class="fas fa-info-circle me-2"></i>
                            Información Importante:
                        </h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-envelope text-info me-2"></i> Recibirá confirmación por email</li>
                            <li><i class="fas fa-phone text-info me-2"></i> Contacto telefónico en 24h</li>
                            <li><i class="fas fa-search text-info me-2"></i> Puede consultar el estado</li>
                        </ul>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                    <a href="<?php echo BASE_URL; ?>check-status" class="btn btn-outline-primary me-md-2">
                        <i class="fas fa-search me-1"></i>
                        Consultar Estado
                    </a>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                        <i class="fas fa-home me-1"></i>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-headset text-primary me-2"></i>
                    ¿Necesita Ayuda?
                </h5>
                <p class="text-muted">
                    Si tiene alguna pregunta sobre su solicitud o necesita asistencia inmediata, 
                    no dude en contactarnos:
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="fas fa-globe me-2 text-primary"></i> 
                           <a href="https://idindustrial.com.mx" target="_blank">idindustrial.com.mx</a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-clock me-2 text-primary"></i> 
                           Horario: Lun-Vie 8:00-18:00
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