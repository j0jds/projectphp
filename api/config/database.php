<?php class Database {
    private $db_path = __DIR__ . '/../../db/database.db';  
    public $conn;

    public function connect() {
        try {
            $this->conn = new PDO("sqlite:" . $this->db_path);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            die();
        }
    }
}
?>
