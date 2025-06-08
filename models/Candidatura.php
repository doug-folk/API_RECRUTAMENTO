<?php
class Candidatura {
    private $id;
    private $id_vaga;
    private $id_pessoa;
    private $score;
    

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->id_vaga = $data['id_vaga'] ?? null;
        $this->id_pessoa = $data['id_pessoa'] ?? null;
        $this->score = $data['score'] ?? null;
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'id_vaga' => $this->id_vaga,
            'id_pessoa' => $this->id_pessoa,
            'score' => $this->score
        ];
    }
    
    public function isValid() {
        if (empty($this->id) || empty($this->id_vaga) || empty($this->id_pessoa)) {
            return false;
        }
        
        if (!Validator::validateUuid($this->id) || 
            !Validator::validateUuid($this->id_vaga) || 
            !Validator::validateUuid($this->id_pessoa)) {
            return false;
        }
        
        return true;
    }
        
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getIdVaga() {
        return $this->id_vaga;
    }
    
    public function setIdVaga($id_vaga) {
        $this->id_vaga = $id_vaga;
        return $this;
    }
    
    public function getIdPessoa() {
        return $this->id_pessoa;
    }
    
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }
    
    public function getScore() {
        return $this->score;
    }
    
    public function setScore($score) {
        $this->score = $score;
        return $this;
    }
}

