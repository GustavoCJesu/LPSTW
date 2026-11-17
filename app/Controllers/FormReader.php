<?php

namespace App\Controllers;

use App\Services\CnpjService;
use App\Services\LeadCard;
use App\Services\LeadValidator;
use App\Services\RateLimiter;
use App\Services\TrelloService;
use App\Services\RecaptchaService;
use GuzzleHttp\Client;

/** Recebe o formulário de orçamento e cria o card do lead no Trello. */
class FormReader
{
    /** Envios por IP: no máximo 2 a cada 10 minutos e 4 por dia. */
    private const LIMITES = [600 => 2, 86400 => 4];

    /** Pasta onde o RateLimiter guarda as tentativas. */
    private const PASTA_LIMITES = __DIR__ . '/../../storage/limites';

    /** POST /sendForm: valida o lead e cria o card no Trello (responde em JSON). */
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

        $ip = $this->ipDoCliente();

        $espera = (new RateLimiter(self::PASTA_LIMITES, self::LIMITES, $_ENV['SECRET_KEY'] ?? ''))->tentar($ip);
        if ($espera > 0) {
            http_response_code(429);
            header('Retry-After: ' . $espera);
            echo json_encode([
                'success' => false,
                'message' => 'Você enviou muitas solicitações em pouco tempo. Tente novamente '
                    . $this->tempoDeEspera($espera) . ' ou escreva para contato@stw.com.br.',
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

        if (!$recaptcha->verify($token, $ip ?: null)) {
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível validar o captcha. Marque a verificação novamente e reenvie.'
            ]);
            return;
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

    /** IP do visitante (atrás de proxy, defina IP_HEADER no .env). */
    private function ipDoCliente(): string
    {
        $cabecalho = $_ENV['IP_HEADER'] ?? '';
        $ip = $cabecalho !== '' ? ($_SERVER[$cabecalho] ?? '') : '';

        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : ($_SERVER['REMOTE_ADDR'] ?? '');
    }

    /** "em 3 minutos" ou "em cerca de 2 horas". */
    private function tempoDeEspera(int $segundos): string
    {
        if ($segundos < 3600) {
            $minutos = max(1, (int) ceil($segundos / 60));
            return $minutos === 1 ? 'em 1 minuto' : "em {$minutos} minutos";
        }

        $horas = (int) ceil($segundos / 3600);
        return $horas === 1 ? 'em cerca de 1 hora' : "em cerca de {$horas} horas";
    }
}
