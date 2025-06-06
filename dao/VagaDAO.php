<?php
require_once 'IDAO.php';

class VagaDAO implements IDAO {
    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }
    
    public function insert($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO vagas (id, empresa, titulo, descricao, localizacao, nivel)
                VALUES (:id, :empresa, :titulo, :descricao, :localizacao, :nivel)
            ");

            $id = $data["id"];
            $empresa = $data["empresa"];
            $titulo = $data["titulo"];
            $descricao = $data["descricao"] ?? null;
            $localizacao = $data["localizacao"];
            $nivel = $data["nivel"];

            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":empresa",$empresa);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":localizacao",$localizacao);
            $stmt->bindParam(":nivel", $nivel);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function findById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM vagas WHERE id = :id");
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
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM vagas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCandidatosRanking($vagaId) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.id as id_candidatura, p.id as id_pessoa, p.nome, p.profissao, p.localizacao, p.nivel, c.score
                FROM candidaturas c
                JOIN pessoas p ON c.id_pessoa = p.id
                WHERE c.id_vaga = :vagaId
                ORDER BY c.score DESC
            ");
            
            $stmt->bindParam(':vagaId', $vagaId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}

