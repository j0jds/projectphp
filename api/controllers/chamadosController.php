<?php
require_once __DIR__ . '/../config/database.php';

class ChamadosController {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Lista os chamados
    public function listarChamados() {
        $query = "SELECT * FROM chamados";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($chamados);
    }

    // Cria um chamado
    public function criarChamado($titulo, $descricao, $status = 'Aberto') {
        $query = "INSERT INTO chamados (titulo, descricao, status) VALUES (:titulo, :descricao, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Chamado criado com sucesso']);
        } else {
            echo json_encode(['message' => 'Erro ao criar o chamado']);
        }
    }

    // Atualiza um chamado
    public function atualizarChamado($id, $titulo, $descricao, $status) {
        $query = "UPDATE chamados SET titulo = :titulo, descricao = :descricao, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Chamado atualizado com sucesso']);
        } else {
            echo json_encode(['message' => 'Erro ao atualizar o chamado']);
        }
    }

    // Exclui um chamado
    public function excluirChamado($id) {
        $query = "DELETE FROM chamados WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Chamado excluído com sucesso']);
        } else {
            echo json_encode(['message' => 'Erro ao excluir o chamado']);
        }
    }
}
?>
