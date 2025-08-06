<?php
/**
 * Controlador de Solicitudes
 * Sistema de Solicitud de Servicios - ID INDUSTRIAL
 */

require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class SolicitudController {
    private $solicitud;
    private $usuario;
    private $auth;
    
    public function __construct() {
        $this->solicitud = new Solicitud();
        $this->usuario = new Usuario();
        $this->auth = new AuthController();
    }
    
    /**
     * Mostrar formulario de nueva solicitud
     */
    public function showForm() {
        $tiposServicio = $this->solicitud->getTiposServicio();
        $csrfToken = $this->auth->generateCSRFToken();
        
        include __DIR__ . '/../views/solicitud/form.php';
    }
    
    /**
     * Procesar nueva solicitud
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        
        // Validar CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!$this->auth->validateCSRFToken($csrfToken)) {
            die('Token CSRF inválido');
        }
        
        $errors = [];
        $data = [
            'usuario_id' => $_SESSION['user_id'] ?? null,
            'tipo_servicio_id' => intval($_POST['tipo_servicio_id'] ?? 0),
            'titulo' => trim($_POST['titulo'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'prioridad' => $_POST['prioridad'] ?? 'media',
            'direccion_servicio' => trim($_POST['direccion_servicio'] ?? ''),
            'contacto_sitio' => trim($_POST['contacto_sitio'] ?? ''),
            'telefono_contacto' => trim($_POST['telefono_contacto'] ?? ''),
            'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? null,
            'observaciones' => trim($_POST['observaciones'] ?? '')
        ];
        
        // Validaciones
        if (empty($data['titulo'])) {
            $errors[] = 'El título es requerido';
        }
        
        if (empty($data['descripcion'])) {
            $errors[] = 'La descripción es requerida';
        }
        
        if ($data['tipo_servicio_id'] <= 0) {
            $errors[] = 'Debe seleccionar un tipo de servicio';
        }
        
        if (empty($data['direccion_servicio'])) {
            $errors[] = 'La dirección del servicio es requerida';
        }
        
        if (empty($data['contacto_sitio'])) {
            $errors[] = 'El contacto en sitio es requerido';
        }
        
        if (empty($data['telefono_contacto'])) {
            $errors[] = 'El teléfono de contacto es requerido';
        }
        
        // Validar fecha si se proporcionó
        if (!empty($data['fecha_vencimiento'])) {
            $fecha = DateTime::createFromFormat('Y-m-d', $data['fecha_vencimiento']);
            if (!$fecha || $fecha->format('Y-m-d') !== $data['fecha_vencimiento']) {
                $errors[] = 'Formato de fecha inválido';
            } elseif ($fecha < new DateTime()) {
                $errors[] = 'La fecha de vencimiento no puede ser en el pasado';
            }
        }
        
        if (empty($errors)) {
            try {
                $solicitudId = $this->solicitud->create($data);
                
                if ($solicitudId) {
                    $_SESSION['success_message'] = 'Solicitud creada exitosamente. ID: ' . $solicitudId;
                    header('Location: index.php?success=1');
                    exit;
                } else {
                    $errors[] = 'Error al crear la solicitud';
                }
            } catch (Exception $e) {
                $errors[] = 'Error del sistema: ' . $e->getMessage();
            }
        }
        
        // Si hay errores, mostrar el formulario con errores
        $tiposServicio = $this->solicitud->getTiposServicio();
        $csrfToken = $this->auth->generateCSRFToken();
        include __DIR__ . '/../views/solicitud/form.php';
    }
    
    /**
     * Listar solicitudes (para administrador)
     */
    public function index() {
        $this->auth->requireAuth();
        
        $filters = [
            'estado' => $_GET['estado'] ?? '',
            'tecnico_id' => $_GET['tecnico_id'] ?? '',
            'tipo_servicio_id' => $_GET['tipo_servicio_id'] ?? '',
            'fecha_desde' => $_GET['fecha_desde'] ?? '',
            'fecha_hasta' => $_GET['fecha_hasta'] ?? '',
            'limit' => $_GET['limit'] ?? 50
        ];
        
        $solicitudes = $this->solicitud->getAll($filters);
        $tecnicos = $this->usuario->getTecnicos();
        $tiposServicio = $this->solicitud->getTiposServicio();
        
        include __DIR__ . '/../views/solicitud/index.php';
    }
    
    /**
     * Ver detalle de solicitud
     */
    public function view($id) {
        $this->auth->requireAuth();
        
        $solicitudData = $this->solicitud->getById($id);
        
        if (!$solicitudData) {
            http_response_code(404);
            die('Solicitud no encontrada');
        }
        
        $comentarios = $this->solicitud->getComentarios($id);
        $tecnicos = $this->usuario->getTecnicos();
        
        include __DIR__ . '/../views/solicitud/view.php';
    }
    
    /**
     * Asignar técnico a solicitud
     */
    public function asignarTecnico() {
        $this->auth->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        
        $solicitudId = intval($_POST['solicitud_id'] ?? 0);
        $tecnicoId = intval($_POST['tecnico_id'] ?? 0);
        
        if ($solicitudId > 0 && $tecnicoId > 0) {
            $result = $this->solicitud->asignarTecnico($solicitudId, $tecnicoId);
            
            if ($result) {
                $_SESSION['success_message'] = 'Técnico asignado exitosamente';
            } else {
                $_SESSION['error_message'] = 'Error al asignar técnico';
            }
        } else {
            $_SESSION['error_message'] = 'Datos inválidos';
        }
        
        header('Location: dashboard.php?view=solicitud&id=' . $solicitudId);
        exit;
    }
    
    /**
     * Actualizar estado de solicitud
     */
    public function updateEstado() {
        $this->auth->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        
        $solicitudId = intval($_POST['solicitud_id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $costo_final = $_POST['costo_final'] ?? null;
        $observaciones = $_POST['observaciones'] ?? '';
        
        $validStates = ['pendiente', 'asignada', 'en_proceso', 'completada', 'cancelada'];
        
        if ($solicitudId > 0 && in_array($estado, $validStates)) {
            $data = [];
            
            if (!empty($costo_final) && is_numeric($costo_final)) {
                $data['costo_final'] = floatval($costo_final);
            }
            
            if (!empty($observaciones)) {
                $data['observaciones'] = $observaciones;
            }
            
            $result = $this->solicitud->updateEstado($solicitudId, $estado, $data);
            
            if ($result) {
                $_SESSION['success_message'] = 'Estado actualizado exitosamente';
            } else {
                $_SESSION['error_message'] = 'Error al actualizar estado';
            }
        } else {
            $_SESSION['error_message'] = 'Datos inválidos';
        }
        
        header('Location: dashboard.php?view=solicitud&id=' . $solicitudId);
        exit;
    }
    
    /**
     * Agregar comentario a solicitud
     */
    public function addComentario() {
        $this->auth->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        
        $solicitudId = intval($_POST['solicitud_id'] ?? 0);
        $comentario = trim($_POST['comentario'] ?? '');
        $currentUser = $this->auth->getCurrentUser();
        
        if ($solicitudId > 0 && !empty($comentario) && $currentUser) {
            $result = $this->solicitud->addComentario($solicitudId, $currentUser['id'], $comentario);
            
            if ($result) {
                $_SESSION['success_message'] = 'Comentario agregado exitosamente';
            } else {
                $_SESSION['error_message'] = 'Error al agregar comentario';
            }
        } else {
            $_SESSION['error_message'] = 'Datos inválidos';
        }
        
        header('Location: dashboard.php?view=solicitud&id=' . $solicitudId);
        exit;
    }
}
?>