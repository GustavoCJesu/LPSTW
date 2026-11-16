<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CnpjService
{
    private const API_URL = 'https://brasilapi.com.br/api/cnpj/v1/';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function consultar(string $cnpj): ?array
    {
        $cnpj = preg_replace('/[^0-9A-Z]/', '', strtoupper($cnpj));

        if (strlen($cnpj) !== 14) {
            return null;
        }

        try {
            $response = $this->client->get(self::API_URL . $cnpj, [
                'timeout' => 5,
                'connect_timeout' => 3,
                'http_errors' => false,
            ]);

            if ($response->getStatusCode() !== 200) {
                return null;
            }

            $dados = json_decode((string) $response->getBody(), true);
            return is_array($dados) ? $dados : null;
        } catch (GuzzleException $e) {
            error_log('CnpjService::consultar failed: ' . $e->getMessage());
            return null;
        }
    }
}
