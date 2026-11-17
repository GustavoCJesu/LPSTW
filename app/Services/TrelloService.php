<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/** Integração com a API do Trello (credenciais no .env). */
class TrelloService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /** Cria um card na lista ID_LIST. Retorna false em caso de falha. */
    public function createCard(array $data) : bool
    {
        try {
            $this->client->post(
                $_ENV['BASE_URL'],
                [
                    'query' => [
                        'idList' => $_ENV['ID_LIST'],
                        'key' => $_ENV['API_KEY'],
                        'token' => $_ENV['API_TOKEN']
                    ],
                    'json' => [
                        'name' => $data['name'],
                        'desc' => $data['desc'],
                        'pos' => $data['pos'] ?? 'bottom',
                    ]
                ]
            );
            return true;
        } catch (GuzzleException $e) {

            error_log('TrelloService::createCard failed: ' . $e->getMessage());
            return false;
        }
    }
}
