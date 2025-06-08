<?php
require_once 'models/Candidatura.php';
require_once 'dao/CandidaturaDAO.php';
require_once 'dao/VagaDAO.php';
require_once 'dao/PessoaDAO.php';
require_once 'utils/Validator.php';
require_once 'utils/ScoreCalculator.php';
require_once 'utils/DistanceCalculator.php';

class CandidaturaController {
    private $candidaturaDAO;
    private $vagaDAO;
    private $pessoaDAO;
    private $scoreCalculator;

    public function __construct() {
        $this->candidaturaDAO = new CandidaturaDAO();
        $this->vagaDAO = new VagaDAO();
        $this->pessoaDAO = new PessoaDAO();
        $this->scoreCalculator = new ScoreCalculator();
    }
    

    public function create() {
        try {
            $jsonData = file_get_contents('php://input');
            
            // Valida o JSON
            $data = Validator::validateJson($jsonData);
            if ($data === null) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            $candidatura = new Candidatura($data);
            
            if (!$candidatura->isValid()) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            if ($this->candidaturaDAO->exists($candidatura->getId())) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            $vaga = $this->vagaDAO->findById($candidatura->getIdVaga());
            if (!$vaga) {
                jsonResponse(null, HTTP_NOT_FOUND);
            }
            
            $pessoa = $this->pessoaDAO->findById($candidatura->getIdPessoa());
            if (!$pessoa) {
                jsonResponse(null, HTTP_NOT_FOUND);
            }
            
            if ($this->candidaturaDAO->existsByVagaAndPessoa($candidatura->getIdVaga(), $candidatura->getIdPessoa())) {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
            
            $score = $this->scoreCalculator->calcularScore(
                $vaga['nivel'],
                $pessoa['nivel'],
                $vaga['localizacao'],
                $pessoa['localizacao']
            );
            
            $candidatura->setScore($score);
            
            $result = $this->candidaturaDAO->insert($candidatura->toArray());
            
            if ($result) {
                jsonResponse(null, HTTP_CREATED);
            } else {
                jsonResponse(null, HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            jsonResponse(null, HTTP_BAD_REQUEST);
        }
    }
}

