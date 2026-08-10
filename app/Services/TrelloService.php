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
            $response = $this->client->post(
                $_ENV['BASE_URL'],
                [
                    'query' => [
                        'idList' => $_ENV['ID_LIST'],
                        'key' => $_ENV['API_KEY'],
                        'token' => $_ENV['API_TOKEN']
                    ],
                    'json' => [
                        'name' => $data['name'],
                        'desc' => "**Nome:** {$data['name']} \nCNPJ: {$data['cnpj']} \n \nEmail: {$data['email']} \nTelefone: {$data['telefone']} \nColaboradores: {$data['colaboradores']} \n \nMensagem: {$data['mensagem']}",
                        'pos' => $data['pos'],
                        'date' => $data['date']
                    ]
                ]
            );
            // var_dump($response->getStatusCode());
            // return json_decode($response->getBody(), true);
            return true;
        } catch (GuzzleException $e) {

            error_log('TrelloService::createCard failed: ' . $e->getMessage());
            return false;
        }
    }
}
