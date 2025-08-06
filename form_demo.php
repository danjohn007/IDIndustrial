<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud - ID INDUSTRIAL</title>
    
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
        
        .demo-banner {
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            color: white;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Demo Banner -->
    <div class="demo-banner">
        <i class="fas fa-star me-2"></i>
        DEMO - Formulario Elegante de Solicitud de Servicios Industriales
        <i class="fas fa-star ms-2"></i>
    </div>

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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <div class="form-header">
                        <h2><i class="fas fa-clipboard-list me-3"></i>Solicitud de Servicio Industrial</h2>
                        <p class="mb-0">Complete el formulario para solicitar nuestros servicios especializados</p>
                    </div>
                    
                    <div class="form-body">
                        <div class="info-box">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Demo del formulario:</strong> Este es el formulario elegante implementado con todas las validaciones y características requeridas.
                        </div>
                        
                        <form id="solicitudForm" onsubmit="showDemo(event)">
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
                                                <option value="1" selected>Mantenimiento Preventivo</option>
                                                <option value="2">Mantenimiento Correctivo</option>
                                                <option value="3">Instalación</option>
                                                <option value="4">Capacitación</option>
                                                <option value="5">Consultoría</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioridad" class="form-label">Prioridad</label>
                                            <select class="form-select" id="prioridad" name="prioridad">
                                                <option value="baja">Baja</option>
                                                <option value="media" selected>Media</option>
                                                <option value="alta">Alta</option>
                                                <option value="urgente">Urgente</option>
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
                                           value="Mantenimiento preventivo de línea de producción">
                                    <div class="character-count">
                                        <span id="titulo-count">46</span>/200 caracteres
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">
                                        Descripción Detallada <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" 
                                              placeholder="Describa detalladamente el servicio requerido..."
                                              maxlength="1000" required>Requerimos mantenimiento preventivo completo de la línea de producción principal, incluyendo revisión de sistemas hidráulicos, eléctricos y mecánicos. Es necesario verificar el estado de rodamientos, sistemas de lubricación y calibración de sensores.</textarea>
                                    <div class="character-count">
                                        <span id="descripcion-count">312</span>/1000 caracteres
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="fecha_vencimiento" class="form-label">Fecha Límite Deseada</label>
                                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                                           min="2025-08-07" value="2025-08-15">
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
                                              placeholder="Dirección completa donde se realizará el servicio"
                                              maxlength="300" required>Av. Industrial 1234, Zona Industrial Norte, León, Guanajuato, CP 37490</textarea>
                                    <div class="character-count">
                                        <span id="direccion-count">83</span>/300 caracteres
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
                                                   value="Ing. Carlos Hernández">
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
                                                   value="477-123-4567">
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
                                              placeholder="Información adicional que considere importante..."
                                              maxlength="500">El mantenimiento debe realizarse durante el turno nocturno (22:00 - 06:00) para no interrumpir la producción. Se requiere coordinación previa con el departamento de seguridad.</textarea>
                                    <div class="character-count">
                                        <span id="observaciones-count">219</span>/500 caracteres
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
                                </button>
                                <button type="button" class="btn btn-secondary ms-3" onclick="clearForm()">
                                    <i class="fas fa-refresh me-2"></i>Limpiar Formulario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function showDemo(event) {
            event.preventDefault();
            
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                alert('¡Demo del formulario de solicitud!\n\nEn el sistema real, esto:\n\n• Valida todos los campos\n• Guarda la solicitud en la base de datos\n• Envía notificaciones por email\n• Redirige a página de confirmación\n• Genera número de folio único\n\nCaracterísticas implementadas:\n• Validación en tiempo real\n• Contadores de caracteres\n• Diseño responsive\n• Seguridad CSRF\n• Auto-guardado local');
                
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Solicitud';
                submitBtn.disabled = false;
            }, 2000);
        }
        
        function clearForm() {
            if (confirm('¿Está seguro que desea limpiar el formulario?')) {
                document.getElementById('solicitudForm').reset();
                updateCharacterCounts();
            }
        }
        
        function updateCharacterCounts() {
            const fields = [
                { id: 'titulo', countId: 'titulo-count' },
                { id: 'descripcion', countId: 'descripcion-count' },
                { id: 'direccion_servicio', countId: 'direccion-count' },
                { id: 'observaciones', countId: 'observaciones-count' }
            ];
            
            fields.forEach(field => {
                const element = document.getElementById(field.id);
                const counter = document.getElementById(field.countId);
                if (element && counter) {
                    counter.textContent = element.value.length;
                }
            });
        }
        
        // Initialize character counts
        document.addEventListener('DOMContentLoaded', updateCharacterCounts);
    </script>
</body>
</html>