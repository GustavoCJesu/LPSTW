<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TrelloService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

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
