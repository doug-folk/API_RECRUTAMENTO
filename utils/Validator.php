<?php

class Validator {

    public static function validateJson($jsonStr) {
        $data = json_decode($jsonStr, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        
        return $data;
    }
    
    public static function validateUuid($uuid) {
        $pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i';
        return preg_match($pattern, $uuid) === 1;
    }
    
    public static function validateVaga($data) {
        if (!isset($data['id']) || !isset($data['empresa']) || !isset($data['titulo']) || 
            !isset($data['localizacao']) || !isset($data['nivel'])) {
            return false;
        }
        
        if (!self::validateUuid($data['id'])) {
            return false;
        }
        
        if (!preg_match('/^[A-Z]$/', $data['localizacao'])) {
            return false;
        }
        
        if (!is_numeric($data['nivel']) || $data['nivel'] < 1 || $data['nivel'] > 5) {
            return false;
        }
        
        return true;
    }

    public static function validatePessoa($data) {
        if (!isset($data['id']) || !isset($data['nome']) || !isset($data['profissao']) || 
            !isset($data['localizacao']) || !isset($data['nivel'])) {
            return false;
        }
        
        if (!self::validateUuid($data['id'])) {
            return false;
        }
        
        if (!preg_match('/^[A-Z]$/', $data['localizacao'])) {
            return false;
        }
        
        if (!is_numeric($data['nivel']) || $data['nivel'] < 1 || $data['nivel'] > 5) {
            return false;
        }
        
        return true;
    }
    
    public static function validateCandidatura($data) {
        if (!isset($data['id']) || !isset($data['id_vaga']) || !isset($data['id_pessoa'])) {
            return false;
        }
        
        if (!self::validateUuid($data['id']) || !self::validateUuid($data['id_vaga']) || 
            !self::validateUuid($data['id_pessoa'])) {
            return false;
        }
        
        return true;
    }
}

