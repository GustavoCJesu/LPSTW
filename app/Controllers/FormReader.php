<?php

namespace App\Controllers;

use App\Services\CnpjService;
use App\Services\LeadCard;
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

        $lead = [];
        foreach (['nome', 'cnpj', 'email', 'telefone', 'colaboradores', 'mensagem'] as $campo) {
            $lead[$campo] = trim((string) ($_POST[$campo] ?? ''));
        }

        $empresa = (new CnpjService($client))->consultar($lead['cnpj']);
        $card = new LeadCard($lead, $empresa);

        $trelloService = new TrelloService();

        $result = $trelloService->createCard([
            'name' => $card->titulo(),
            'desc' => $card->descricao(),
            'pos' => 'bottom',
        ]);

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
