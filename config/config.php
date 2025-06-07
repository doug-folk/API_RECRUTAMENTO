<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'recrutamento_api');
define('DB_USER', 'root');
define('DB_PASS', 'RootR@t1');
define('DB_CHARSET', 'utf8mb4');

define('BASE_URL', '/api/'); 
define('DEBUG_MODE', true);

define('NIVEL_ESTAGIARIO', 1);
define('NIVEL_JUNIOR', 2);
define('NIVEL_PLENO', 3);
define('NIVEL_SENIOR', 4);
define('NIVEL_ESPECIALISTA', 5);

define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_NOT_FOUND', 404);
define('HTTP_UNPROCESSABLE_ENTITY', 422);

function handleError($errno, $errstr, $errfile, $errline) {
    if (DEBUG_MODE) {
        echo json_encode([
            'error' => $errstr,
            'file' => $errfile,
            'line' => $errline
        ]);
    } else {
        http_response_code(500 );
        echo json_encode(['error' => 'Erro interno do servidor']);
    }
    exit;
}

set_error_handler('handleError');

function jsonResponse($data = null, $statusCode = HTTP_OK) {
    http_response_code($statusCode );
    header('Content-Type: application/json');
    
    if ($data !== null) {
        echo json_encode($data);
    }
    exit;
}
