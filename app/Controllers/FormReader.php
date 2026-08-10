<?php

namespace App\Controllers;

use App\Services\TrelloService;
use LDAP\Result;

class FormReader
{

    public function getForm()
    {

        $data = [
            'name' => 'Lead - ' . $_POST['nome'] ?? 'Não informado',
            'cnpj' => $_POST['cnpj'] ?? 'Não informado',
            'email' => $_POST['email'] ?? 'Não informado',
            'telefone' => $_POST['telefone'] ?? 'Não informado',
            'colaboradores' => $_POST['colaboradores'] ?? 'Não informado',
            'mensagem' => "\n" . $_POST['mensagem'] ?? 'Não informado',
            'pos' => 'bottom',
            'date' => date('d/m/y'),
        ];


        $trelloService = new TrelloService();

        $result = $trelloService->createCard($data);

        header('Content-Type: Application/json');

        if ($result) {
            echo json_encode([
                    'success' => true,
                    'message' => 'Card criado com sucesso'
                ]);
                return;
        }

        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível criar o card'
        ]);
    }
}
