<?php
require_once 'models/Vaga.php';
require_once 'dao/VagaDAO.php';
require_once 'utils/Validator.php';

class VagaController {
    private $vagaDAO;

    public function __construct() {
        $this->vagaDAO = new VagaDAO();
    }

    public function create() {
        try {
            $jsonData = file_get_contents('php://input');
            
            $data = Validator::validateJson($jsonData);
            if ($data === null) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            $vaga = new Vaga($data);

            if (!$vaga->isValid()) {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
            
            if ($this->vagaDAO->exists($vaga->getId())) {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
            
            $result = $this->vagaDAO->insert($vaga->toArray());
            
            if ($result) {
                jsonResponse(null, HTTP_CREATED);
            } else {
                jsonResponse(null, HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (Exception $e) {
            jsonResponse(null, HTTP_BAD_REQUEST);
        }
    }
    
    public function getRanking($id) {
        try {

            if (!Validator::validateUuid($id)) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }

            if (!$this->vagaDAO->exists($id)) {
                jsonResponse(null, HTTP_NOT_FOUND);
            }

            $candidatos = $this->vagaDAO->getCandidatosRanking($id);

            $response = [
                'candidaturas' => []
            ];
            
            foreach ($candidatos as $candidato) {
                $response['candidaturas'][] = [
                    'nome' => $candidato['nome'],
                    'profissao' => $candidato['profissao'],
                    'localizacao' => $candidato['localizacao'],
                    'nivel' => (int)$candidato['nivel'],
                    'score' => (int)$candidato['score']
                ];
            }
            
            jsonResponse($response, HTTP_OK);
        } catch (Exception $e) {
            jsonResponse(null, HTTP_BAD_REQUEST);
        }
    }
}

