<?php

class AdminController {
    private $db;
    private $serviceRequest;
    private $user;

    public function __construct() {
        // Verificar autenticación
        AuthController::requireAuth();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->serviceRequest = new ServiceRequest($this->db);
        $this->user = new User($this->db);
    }

    // Dashboard principal
    public function index() {
        // Obtener estadísticas
        $statistics = $this->serviceRequest->getStatistics();
        
        // Obtener últimas solicitudes
        $stmt = $this->serviceRequest->read();
        $recent_requests = [];
        $count = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC) && $count < 5) {
            $recent_requests[] = $row;
            $count++;
        }

        include_once __DIR__ . '/../views/admin/dashboard.php';
    }

    // Listar todas las solicitudes
    public function requests() {
        $status_filter = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        // Construir query con filtros
        $where_conditions = [];
        $params = [];

        if (!empty($status_filter)) {
            $where_conditions[] = "sr.status = :status";
            $params[':status'] = $status_filter;
        }

        if (!empty($search)) {
            $where_conditions[] = "(sr.request_number LIKE :search OR sr.company_name LIKE :search OR sr.contact_name LIKE :search)";
            $params[':search'] = "%{$search}%";
        }

        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

        $query = "SELECT sr.*, u.full_name as assigned_user 
                  FROM service_requests sr 
                  LEFT JOIN users u ON sr.assigned_to = u.id 
                  {$where_clause}
                  ORDER BY sr.created_at DESC";

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();

        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener usuarios para asignación
        $users_stmt = $this->user->readAll();
        $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

        include_once __DIR__ . '/../views/admin/requests.php';
    }

    // Ver detalles de una solicitud
    public function viewRequest() {
        $id = $_GET['id'] ?? 0;
        
        $this->serviceRequest->id = $id;
        if ($this->serviceRequest->readOne()) {
            // Obtener usuarios para asignación
            $users_stmt = $this->user->readAll();
            $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
            
            include_once __DIR__ . '/../views/admin/request_detail.php';
        } else {
            $_SESSION['error'] = "Solicitud no encontrada.";
            header("Location: " . BASE_URL . "admin/requests");
            exit;
        }
    }

    // Actualizar solicitud
    public function updateRequest() {
        if ($_POST && isset($_POST['id'])) {
            $this->serviceRequest->id = $_POST['id'];
            
            if ($this->serviceRequest->readOne()) {
                // Actualizar campos
                $this->serviceRequest->status = $_POST['status'] ?? $this->serviceRequest->status;
                $this->serviceRequest->priority = $_POST['priority'] ?? $this->serviceRequest->priority;
                $this->serviceRequest->estimated_date = !empty($_POST['estimated_date']) ? $_POST['estimated_date'] : null;
                $this->serviceRequest->completion_date = !empty($_POST['completion_date']) ? $_POST['completion_date'] : null;
                $this->serviceRequest->admin_notes = $_POST['admin_notes'] ?? '';
                $this->serviceRequest->assigned_to = !empty($_POST['assigned_to']) ? $_POST['assigned_to'] : null;

                if ($this->serviceRequest->update()) {
                    $_SESSION['success'] = "Solicitud actualizada exitosamente.";
                } else {
                    $_SESSION['error'] = "Error al actualizar la solicitud.";
                }
            } else {
                $_SESSION['error'] = "Solicitud no encontrada.";
            }
        }

        header("Location: " . BASE_URL . "admin/requests");
        exit;
    }

    // Exportar solicitudes a CSV
    public function exportCSV() {
        $stmt = $this->serviceRequest->read();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="solicitudes_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Cabeceras CSV
        fputcsv($output, [
            'Número', 'Empresa', 'Contacto', 'Email', 'Teléfono', 
            'Tipo de Servicio', 'Estado', 'Prioridad', 'Fecha Creación', 
            'Fecha Estimada', 'Asignado a'
        ]);
        
        // Datos
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['request_number'],
                $row['company_name'],
                $row['contact_name'],
                $row['contact_email'],
                $row['contact_phone'],
                $row['service_type'],
                $row['status'],
                $row['priority'],
                $row['created_at'],
                $row['estimated_date'],
                $row['assigned_user']
            ]);
        }
        
        fclose($output);
        exit;
    }

    // Gestión de usuarios (solo admin)
    public function users() {
        AuthController::requireAdmin();
        
        $users_stmt = $this->user->readAll();
        $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include_once __DIR__ . '/../views/admin/users.php';
    }
}