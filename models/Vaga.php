<?php

class Vaga {
    private $id;
    private $empresa;
    private $titulo;
    private $descricao;
    private $localizacao;
    private $nivel;
    
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->empresa = $data['empresa'] ?? null;
        $this->titulo = $data['titulo'] ?? null;
        $this->descricao = $data['descricao'] ?? null;
        $this->localizacao = $data['localizacao'] ?? null;
        $this->nivel = $data['nivel'] ?? null;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'empresa' => $this->empresa,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'localizacao' => $this->localizacao,
            'nivel' => $this->nivel
        ];
    }

    public function isValid() {
        if (empty($this->id) || empty($this->empresa) || empty($this->titulo) || 
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
    
    public function getEmpresa() {
        return $this->empresa;
    }
    
    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
        return $this;
    }
    
    public function getTitulo() {
        return $this->titulo;
    }
    
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
        return $this;
    }
    
    public function getDescricao() {
        return $this->descricao;
    }
    
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
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

