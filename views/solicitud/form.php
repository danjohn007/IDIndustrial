<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Servicio - <?php echo APP_NAME; ?></title>
    
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
        
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            padding: 0;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .form-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .form-body {
            padding: 2rem;
        }
        
        .form-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #3498db;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.5rem;
            color: #3498db;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding: 12px 16px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .required {
            color: #dc3545;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 10px;
            padding: 15px 40px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }
        
        .btn-cancel {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            border-radius: 10px;
            padding: 15px 40px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            background: linear-gradient(135deg, #5a6268, #3d4043);
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 2rem;
        }
        
        .priority-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .priority-baja { background-color: #d1ecf1; color: #0c5460; }
        .priority-media { background-color: #fff3cd; color: #856404; }
        .priority-alta { background-color: #f8d7da; color: #721c24; }
        .priority-urgente { background-color: #f5c6cb; color: #491217; }
        
        .info-box {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #2196f3;
        }
        
        .character-count {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: right;
            margin-top: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .form-body {
                padding: 1.5rem;
            }
            
            .form-section {
                padding: 1rem;
            }
            
            .btn-submit, .btn-cancel {
                width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-industry me-3"></i><?php echo APP_NAME; ?></h1>
                    <p class="mb-0">Sistema de Solicitud de Servicios Industriales</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="index.php" class="btn btn-outline-light">
                        <i class="fas fa-home me-2"></i>Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <div class="form-header">
                        <h2><i class="fas fa-clipboard-list me-3"></i>Solicitud de Servicio Industrial</h2>
                        <p class="mb-0">Complete el formulario para solicitar nuestros servicios especializados</p>
                    </div>
                    
                    <div class="form-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Se encontraron los siguientes errores:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="info-box">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Información importante:</strong> Los campos marcados con <span class="required">*</span> son obligatorios. 
                            Nuestro equipo técnico se pondrá en contacto con usted en un plazo máximo de 24 horas.
                        </div>
                        
                        <form method="POST" action="index.php" id="solicitudForm">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                            
                            <!-- Información del Servicio -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-cogs"></i>Información del Servicio
                                </h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tipo_servicio_id" class="form-label">
                                                Tipo de Servicio <span class="required">*</span>
                                            </label>
                                            <select class="form-select" id="tipo_servicio_id" name="tipo_servicio_id" required>
                                                <option value="">Seleccione un tipo de servicio</option>
                                                <?php foreach ($tiposServicio as $tipo): ?>
                                                    <option value="<?php echo $tipo['id']; ?>" 
                                                            <?php echo (isset($_POST['tipo_servicio_id']) && $_POST['tipo_servicio_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioridad" class="form-label">Prioridad</label>
                                            <select class="form-select" id="prioridad" name="prioridad">
                                                <option value="baja" <?php echo (isset($_POST['prioridad']) && $_POST['prioridad'] == 'baja') ? 'selected' : ''; ?>>
                                                    Baja
                                                </option>
                                                <option value="media" <?php echo (!isset($_POST['prioridad']) || $_POST['prioridad'] == 'media') ? 'selected' : ''; ?>>
                                                    Media
                                                </option>
                                                <option value="alta" <?php echo (isset($_POST['prioridad']) && $_POST['prioridad'] == 'alta') ? 'selected' : ''; ?>>
                                                    Alta
                                                </option>
                                                <option value="urgente" <?php echo (isset($_POST['prioridad']) && $_POST['prioridad'] == 'urgente') ? 'selected' : ''; ?>>
                                                    Urgente
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">
                                        Título del Servicio <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" 
                                           placeholder="Ej: Mantenimiento preventivo de compresor industrial"
                                           maxlength="200" required
                                           value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>">
                                    <div class="character-count">
                                        <span id="titulo-count">0</span>/200 caracteres
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">
                                        Descripción Detallada <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                              placeholder="Describa detalladamente el servicio requerido, incluya especificaciones técnicas, modelo de equipos, síntomas o problemas específicos..."
                                              maxlength="1000" required><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                                    <div class="character-count">
                                        <span id="descripcion-count">0</span>/1000 caracteres
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="fecha_vencimiento" class="form-label">Fecha Límite Deseada</label>
                                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                                           min="<?php echo date('Y-m-d'); ?>"
                                           value="<?php echo htmlspecialchars($_POST['fecha_vencimiento'] ?? ''); ?>">
                                    <small class="text-muted">Opcional: Indique cuándo necesita completar el servicio</small>
                                </div>
                            </div>
                            
                            <!-- Información del Sitio -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-map-marker-alt"></i>Información del Sitio
                                </h4>
                                
                                <div class="mb-3">
                                    <label for="direccion_servicio" class="form-label">
                                        Dirección del Servicio <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" id="direccion_servicio" name="direccion_servicio" rows="2"
                                              placeholder="Dirección completa donde se realizará el servicio (calle, número, colonia, ciudad, código postal)"
                                              maxlength="300" required><?php echo htmlspecialchars($_POST['direccion_servicio'] ?? ''); ?></textarea>
                                    <div class="character-count">
                                        <span id="direccion-count">0</span>/300 caracteres
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contacto_sitio" class="form-label">
                                                Persona de Contacto en Sitio <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="contacto_sitio" name="contacto_sitio"
                                                   placeholder="Nombre completo del responsable en sitio"
                                                   maxlength="100" required
                                                   value="<?php echo htmlspecialchars($_POST['contacto_sitio'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefono_contacto" class="form-label">
                                                Teléfono de Contacto <span class="required">*</span>
                                            </label>
                                            <input type="tel" class="form-control" id="telefono_contacto" name="telefono_contacto"
                                                   placeholder="Ej: 555-123-4567"
                                                   pattern="[0-9\-\(\)\s\+]{10,20}" required
                                                   value="<?php echo htmlspecialchars($_POST['telefono_contacto'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Observaciones Adicionales -->
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-sticky-note"></i>Observaciones Adicionales
                                </h4>
                                
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                              placeholder="Información adicional que considere importante: horarios de acceso, requerimientos especiales, materiales disponibles, etc."
                                              maxlength="500"><?php echo htmlspecialchars($_POST['observaciones'] ?? ''); ?></textarea>
                                    <div class="character-count">
                                        <span id="observaciones-count">0</span>/500 caracteres
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
                                </button>
                                <a href="index.php" class="btn btn-secondary btn-cancel ms-3">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contadores de caracteres
            const fields = [
                { id: 'titulo', countId: 'titulo-count', maxLength: 200 },
                { id: 'descripcion', countId: 'descripcion-count', maxLength: 1000 },
                { id: 'direccion_servicio', countId: 'direccion-count', maxLength: 300 },
                { id: 'observaciones', countId: 'observaciones-count', maxLength: 500 }
            ];
            
            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const counter = document.getElementById(field.countId);
                
                function updateCount() {
                    const count = element.value.length;
                    counter.textContent = count;
                    
                    if (count > field.maxLength * 0.9) {
                        counter.style.color = '#dc3545';
                    } else if (count > field.maxLength * 0.7) {
                        counter.style.color = '#ffc107';
                    } else {
                        counter.style.color = '#6c757d';
                    }
                }
                
                element.addEventListener('input', updateCount);
                updateCount(); // Inicial
            });
            
            // Validación de teléfono
            const phoneField = document.getElementById('telefono_contacto');
            phoneField.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length >= 10) {
                    if (value.length === 10) {
                        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
                    } else if (value.length === 11) {
                        value = value.replace(/(\d{1})(\d{3})(\d{3})(\d{4})/, '$1-$2-$3-$4');
                    }
                }
                this.value = value;
            });
            
            // Validación del formulario
            const form = document.getElementById('solicitudForm');
            const submitBtn = document.querySelector('.btn-submit');
            
            form.addEventListener('submit', function(e) {
                // Mostrar loading
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
                submitBtn.disabled = true;
                
                // Validaciones adicionales
                const titulo = document.getElementById('titulo').value.trim();
                const descripcion = document.getElementById('descripcion').value.trim();
                
                if (titulo.length < 10) {
                    e.preventDefault();
                    alert('El título debe tener al menos 10 caracteres');
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Solicitud';
                    submitBtn.disabled = false;
                    return;
                }
                
                if (descripcion.length < 20) {
                    e.preventDefault();
                    alert('La descripción debe tener al menos 20 caracteres');
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Solicitud';
                    submitBtn.disabled = false;
                    return;
                }
            });
            
            // Efecto visual para prioridad
            const prioridadSelect = document.getElementById('prioridad');
            prioridadSelect.addEventListener('change', function() {
                this.className = 'form-select priority-' + this.value;
            });
            
            // Trigger inicial
            prioridadSelect.dispatchEvent(new Event('change'));
            
            // Auto-guardar en localStorage
            const formFields = form.querySelectorAll('input, textarea, select');
            formFields.forEach(field => {
                // Cargar datos guardados
                const savedValue = localStorage.getItem('solicitud_' + field.name);
                if (savedValue && !field.value) {
                    field.value = savedValue;
                    if (field.type === 'textarea') {
                        field.dispatchEvent(new Event('input'));
                    }
                }
                
                // Guardar cambios
                field.addEventListener('input', function() {
                    localStorage.setItem('solicitud_' + this.name, this.value);
                });
            });
            
            // Limpiar localStorage al enviar exitosamente
            form.addEventListener('submit', function() {
                formFields.forEach(field => {
                    localStorage.removeItem('solicitud_' + field.name);
                });
            });
        });
    </script>
</body>
</html>