<?php

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $role;
    public $created_at;
    public $updated_at;
    public $active;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Autenticar usuario
    public function authenticate($username, $password) {
        $query = "SELECT id, username, email, password, full_name, role, active 
                  FROM " . $this->table_name . " 
                  WHERE (username = :username OR email = :username) AND active = 1 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->full_name = $row['full_name'];
            $this->role = $row['role'];
            $this->active = $row['active'];
            return true;
        }
        return false;
    }

    // Obtener usuario por ID
    public function readOne() {
        $query = "SELECT id, username, email, full_name, role, created_at, updated_at, active 
                  FROM " . $this->table_name . " 
                  WHERE id = :id AND active = 1 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->full_name = $row['full_name'];
            $this->role = $row['role'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            $this->active = $row['active'];
            return true;
        }
        return false;
    }

    // Obtener todos los usuarios activos
    public function readAll() {
        $query = "SELECT id, username, email, full_name, role, created_at 
                  FROM " . $this->table_name . " 
                  WHERE active = 1 
                  ORDER BY full_name ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Crear nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (username, email, password, full_name, role) 
                  VALUES 
                  (:username, :email, :password, :full_name, :role)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Hash de la contraseña
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind de parámetros
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":role", $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar si existe el usuario o email
    public function userExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}