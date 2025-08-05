<?php

class ServiceRequest {
    private $conn;
    private $table_name = "service_requests";

    public $id;
    public $request_number;
    public $company_name;
    public $contact_name;
    public $contact_email;
    public $contact_phone;
    public $service_type;
    public $service_description;
    public $priority;
    public $status;
    public $estimated_date;
    public $completion_date;
    public $notes;
    public $admin_notes;
    public $created_at;
    public $updated_at;
    public $assigned_to;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear nueva solicitud
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (request_number, company_name, contact_name, contact_email, contact_phone, 
                   service_type, service_description, priority, status) 
                  VALUES 
                  (:request_number, :company_name, :contact_name, :contact_email, :contact_phone, 
                   :service_type, :service_description, :priority, :status)";

        $stmt = $this->conn->prepare($query);

        // Generar número de solicitud único
        $this->request_number = $this->generateRequestNumber();
        $this->status = 'pendiente';
        $this->priority = $this->priority ?: 'media';

        // Sanitizar datos
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->contact_name = htmlspecialchars(strip_tags($this->contact_name));
        $this->contact_email = htmlspecialchars(strip_tags($this->contact_email));
        $this->contact_phone = htmlspecialchars(strip_tags($this->contact_phone));
        $this->service_type = htmlspecialchars(strip_tags($this->service_type));
        $this->service_description = htmlspecialchars(strip_tags($this->service_description));

        // Bind de parámetros
        $stmt->bindParam(":request_number", $this->request_number);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":contact_name", $this->contact_name);
        $stmt->bindParam(":contact_email", $this->contact_email);
        $stmt->bindParam(":contact_phone", $this->contact_phone);
        $stmt->bindParam(":service_type", $this->service_type);
        $stmt->bindParam(":service_description", $this->service_description);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener todas las solicitudes
    public function read() {
        $query = "SELECT sr.*, u.full_name as assigned_user 
                  FROM " . $this->table_name . " sr 
                  LEFT JOIN users u ON sr.assigned_to = u.id 
                  ORDER BY sr.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Obtener solicitud por ID
    public function readOne() {
        $query = "SELECT sr.*, u.full_name as assigned_user 
                  FROM " . $this->table_name . " sr 
                  LEFT JOIN users u ON sr.assigned_to = u.id 
                  WHERE sr.id = :id 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->request_number = $row['request_number'];
            $this->company_name = $row['company_name'];
            $this->contact_name = $row['contact_name'];
            $this->contact_email = $row['contact_email'];
            $this->contact_phone = $row['contact_phone'];
            $this->service_type = $row['service_type'];
            $this->service_description = $row['service_description'];
            $this->priority = $row['priority'];
            $this->status = $row['status'];
            $this->estimated_date = $row['estimated_date'];
            $this->completion_date = $row['completion_date'];
            $this->notes = $row['notes'];
            $this->admin_notes = $row['admin_notes'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            $this->assigned_to = $row['assigned_to'];
            return true;
        }
        return false;
    }

    // Actualizar solicitud
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET status = :status, 
                      priority = :priority, 
                      estimated_date = :estimated_date, 
                      completion_date = :completion_date, 
                      admin_notes = :admin_notes, 
                      assigned_to = :assigned_to 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":priority", $this->priority);
        $stmt->bindParam(":estimated_date", $this->estimated_date);
        $stmt->bindParam(":completion_date", $this->completion_date);
        $stmt->bindParam(":admin_notes", $this->admin_notes);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Generar número de solicitud único
    private function generateRequestNumber() {
        $prefix = "ID-" . date('Y');
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                  WHERE request_number LIKE :prefix";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":prefix", $prefix . "%");
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'] + 1;
        
        return $prefix . "-" . str_pad($count, 4, "0", STR_PAD_LEFT);
    }

    // Obtener estadísticas
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN status = 'en_proceso' THEN 1 ELSE 0 END) as en_proceso,
                    SUM(CASE WHEN status = 'completado' THEN 1 ELSE 0 END) as completadas,
                    SUM(CASE WHEN status = 'cancelado' THEN 1 ELSE 0 END) as canceladas
                  FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}