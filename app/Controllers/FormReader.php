<?php

namespace App\Controllers;

use App\Services\CnpjService;
use App\Services\LeadCard;
use App\Services\LeadValidator;
use App\Services\TrelloService;
use App\Services\RecaptchaService;
use GuzzleHttp\Client;

/** Recebe o formulário de orçamento e cria o card do lead no Trello. */
class FormReader
{

    /** POST /sendForm: valida, confere o reCAPTCHA, consulta o CNPJ e cria o card. Responde em JSON. */
    public function getForm()
    {
        header('Content-Type: application/json');

        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo json_encode([
                'success' => false,
                'message' => 'Método não permitido.'
            ]);
            return;
        }

        $lead = [];
        foreach (['nome', 'cnpj', 'email', 'telefone', 'colaboradores', 'mensagem'] as $campo) {
            $lead[$campo] = trim((string) ($_POST[$campo] ?? ''));
        }

        $erros = (new LeadValidator())->validar($lead);
        if ($erros) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'Confira os campos do formulário e tente novamente.',
                'errors' => $erros,
            ]);
            return;
        }

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

        // null se a consulta falhar; o card é criado mesmo assim.
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
