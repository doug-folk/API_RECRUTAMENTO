<?php
require_once 'IDAO.php';

class PessoaDAO implements IDAO {
    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }
    

    public function insert($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO pessoas (id, nome, profissao, localizacao, nivel)
                VALUES (:id, :nome, :profissao, :localizacao, :nivel)
            ");
            
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':profissao', $data['profissao']);
            $stmt->bindParam(':localizacao', $data['localizacao']);
            $stmt->bindParam(':nivel', $data['nivel']);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM pessoas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null;
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function exists($id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM pessoas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
