<?php

class PublicController {
    private $db;
    private $serviceRequest;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->serviceRequest = new ServiceRequest($this->db);
    }

    // Mostrar formulario de solicitud
    public function index() {
        include_once __DIR__ . '/../views/public/request_form.php';
    }

    // Procesar solicitud de servicio
    public function submitRequest() {
        if ($_POST) {
            // Validar datos requeridos
            $required_fields = ['company_name', 'contact_name', 'contact_email', 'contact_phone', 'service_type', 'service_description'];
            $errors = [];

            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[] = "El campo " . str_replace('_', ' ', $field) . " es requerido.";
                }
            }

            // Validar email
            if (!empty($_POST['contact_email']) && !filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "El formato del email no es válido.";
            }

            // Validar teléfono (básico)
            if (!empty($_POST['contact_phone']) && !preg_match('/^[0-9\s\-\+\(\)]+$/', $_POST['contact_phone'])) {
                $errors[] = "El formato del teléfono no es válido.";
            }

            if (empty($errors)) {
                // Asignar valores
                $this->serviceRequest->company_name = $_POST['company_name'];
                $this->serviceRequest->contact_name = $_POST['contact_name'];
                $this->serviceRequest->contact_email = $_POST['contact_email'];
                $this->serviceRequest->contact_phone = $_POST['contact_phone'];
                $this->serviceRequest->service_type = $_POST['service_type'];
                $this->serviceRequest->service_description = $_POST['service_description'];
                $this->serviceRequest->priority = $_POST['priority'] ?? 'media';
                $this->serviceRequest->notes = $_POST['notes'] ?? '';

                // Crear solicitud
                if ($this->serviceRequest->create()) {
                    $success_message = "Su solicitud ha sido enviada exitosamente. Número de solicitud: " . $this->serviceRequest->request_number;
                    include_once __DIR__ . '/../views/public/request_success.php';
                } else {
                    $errors[] = "Error al procesar la solicitud. Por favor, inténtelo nuevamente.";
                    include_once __DIR__ . '/../views/public/request_form.php';
                }
            } else {
                include_once __DIR__ . '/../views/public/request_form.php';
            }
        } else {
            // Redireccionar si no hay datos POST
            header("Location: " . BASE_URL);
            exit;
        }
    }

    // Consultar estado de solicitud
    public function checkStatus() {
        $request_number = $_GET['number'] ?? '';
        $request_data = null;
        $error_message = '';

        if (!empty($request_number)) {
            $query = "SELECT request_number, company_name, service_type, status, created_at, estimated_date 
                      FROM service_requests 
                      WHERE request_number = :request_number";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":request_number", $request_number);
            $stmt->execute();

            $request_data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$request_data) {
                $error_message = "No se encontró ninguna solicitud con el número proporcionado.";
            }
        }

        include_once __DIR__ . '/../views/public/check_status.php';
    }
}