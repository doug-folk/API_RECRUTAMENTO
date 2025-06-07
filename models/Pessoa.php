<?php
class Pessoa {
    private $id;
    private $nome;
    private $profissao;
    private $localizacao;
    private $nivel;
    

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nome = $data['nome'] ?? null;
        $this->profissao = $data['profissao'] ?? null;
        $this->localizacao = $data['localizacao'] ?? null;
        $this->nivel = $data['nivel'] ?? null;
    }
    
    public function toArray() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'profissao' => $this->profissao,
            'localizacao' => $this->localizacao,
            'nivel' => $this->nivel
        ];
    }

    public function isValid() {
        if (empty($this->id) || empty($this->nome) || empty($this->profissao) || 
            empty($this->localizacao) || empty($this->nivel)) {
            return false;
        }
        
        if (!Validator::validateUuid($this->id)) {
            return false;
        }
        
        if (!preg_match('/^[A-Z]$/', $this->localizacao)) {
            return false;
        }
        
        if (!is_numeric($this->nivel) || $this->nivel < 1 || $this->nivel > 5) {
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
    
    public function getNome() {
        return $this->nome;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }
    
    public function getProfissao() {
        return $this->profissao;
    }
    
    public function setProfissao($profissao) {
        $this->profissao = $profissao;
        return $this;
    }
    
    public function getLocalizacao() {
        return $this->localizacao;
    }
    
    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
        return $this;
    }
    
    public function getNivel() {
        return $this->nivel;
    }
    
    public function setNivel($nivel) {
        $this->nivel = $nivel;
        return $this;
    }
}
