<?php

namespace App\Controllers;

use App\Services\TrelloService;
use App\Services\RecaptchaService;
use GuzzleHttp\Client;
use LDAP\Result;

class FormReader
{

    public function getForm()
    {
        header('Content-Type: application/json');

        $token = $_POST['g-recaptcha-response'] ?? '';
        $client = new Client();

        $recaptcha = new RecaptchaService($client, $_ENV['SECRET_KEY']);

        if (!$recaptcha->verify($token, $_SERVER['REMOTE_ADDR'] ?? null)) {
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível validar o captcha. Marque a verificação novamente e reenvie.'
            ]);
            return;
        }

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
