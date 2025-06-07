<?php
require_once 'models/Pessoa.php';
require_once 'dao/PessoaDAO.php';
require_once 'utils/Validator.php';

class PessoaController {
    private $pessoaDAO;
    

    public function __construct() {
        $this->pessoaDAO = new PessoaDAO();
    }
    

    public function create() {
        try {
            $jsonData = file_get_contents('php://input');
            
            $data = Validator::validateJson($jsonData);
            if ($data === null) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            $pessoa = new Pessoa($data);
            
            if (!$pessoa->isValid()) {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
            
            if ($this->pessoaDAO->exists($pessoa->getId())) {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
            
            $result = $this->pessoaDAO->insert($pessoa->toArray());
            
            if ($result) {
                jsonResponse(null, HTTP_CREATED);
            } else {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (Exception $e) {
            jsonResponse(null, HTTP_BAD_REQUEST);
        }
    }
}

