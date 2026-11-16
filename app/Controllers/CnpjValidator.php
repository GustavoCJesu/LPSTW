<?php 

$cnpj = preg_replace('/\D/', '', $_GET['cnpj' ?? '']);

if(strlen($cnpj) !== 14){
    http_response_code(422);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['erro' => 'CNPJ inválido']);
    exit;
}



?>