<?php
require_once 'IDAO.php';

class CandidaturaDAO implements IDAO {
    private $conn;
 
    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }
    

    public function insert($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO candidaturas (id, id_vaga, id_pessoa, score)
                VALUES (:id, :id_vaga, :id_pessoa, :score)
            ");
            
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':id_vaga', $data['id_vaga']);
            $stmt->bindParam(':id_pessoa', $data['id_pessoa']);
            $stmt->bindParam(':score', $data['score']);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function findById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM candidaturas WHERE id = :id");
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
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM candidaturas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function existsByVagaAndPessoa($vagaId, $pessoaId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) FROM candidaturas 
                WHERE id_vaga = :id_vaga AND id_pessoa = :id_pessoa
            ");
            
            $stmt->bindParam(':id_vaga', $vagaId);
            $stmt->bindParam(':id_pessoa', $pessoaId);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}

