<?php
namespace App\Services;
use GuzzleHttp\Client;

class RecaptchaService
{
    private Client $client;
    private string $secret;

    public function __construct(Client $client, string $secret)
    {
        $this->client = $client;
        $this->secret = $secret;
    }

    public function verify(string $token, ?string $ip = null): bool
    {

        try {
            $response = $this->client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => $this->secret,
                    'response' => $token,
                    'remoteip' => $ip,
                ],
            ]);
            $dados = json_decode($response->getBody(), true);
            return !empty($dados['success']);

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return false;
        }
    }
}
