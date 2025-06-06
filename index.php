<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/Database.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$requestUri = $_SERVER['REQUEST_URI'];
$basePath = BASE_URL;

$uri = str_replace($basePath, '', $requestUri);

$uri = explode('?', $uri)[0];

$segments = explode('/', trim($uri, '/'));

$controller = null;
$action = null;
$params = [];

// Roteamento básico
if (count($segments) > 0) {
    switch ($segments[0]) {
        case 'vagas':
            require_once 'controllers/VagaController.php';
            $controller = new VagaController();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($segments) === 1) {
                // POST /vagas
                $controller->create();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && count($segments) === 3 && $segments[2] === 'candidaturas' && isset($segments[3]) && $segments[3] === 'ranking') {
                // GET /vagas/{id}/candidaturas/ranking
                $controller->getRanking($segments[1]);
            } else {
                jsonResponse(['error' => 'Rota não encontrada'], HTTP_NOT_FOUND);
            }
            break;
            
        case 'pessoas':
            require_once 'controllers/PessoaController.php';
            $controller = new PessoaController();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($segments) === 1) {
                // POST /pessoas
                $controller->create();
            } else {
                jsonResponse(['error' => 'Rota não encontrada'], HTTP_NOT_FOUND);
            }
            break;
            
        case 'candidaturas':
            require_once 'controllers/CandidaturaController.php';
            $controller = new CandidaturaController();
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($segments) === 1) {
                // POST /candidaturas
                $controller->create();
            } else {
                jsonResponse(['error' => 'Rota não encontrada'], HTTP_NOT_FOUND);
            }
            break;
            
        default:
            jsonResponse(['error' => 'Rota não encontrada'], HTTP_NOT_FOUND);
            break;
    }
} else {
    jsonResponse(['error' => 'Rota não encontrada'], HTTP_NOT_FOUND);
}

