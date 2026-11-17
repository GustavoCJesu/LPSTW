<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/** Consulta os dados da empresa pelo CNPJ em APIs públicas. */
class CnpjService
{
    /** APIs em ordem; confirmarNaoEncontrado refaz o 404 furando o cache. */
    private const FONTES = [
        ['url' => 'https://brasilapi.com.br/api/cnpj/v1/', 'confirmarNaoEncontrado' => false],
        ['url' => 'https://minhareceita.org/', 'confirmarNaoEncontrado' => true],
    ];

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /** Dados da empresa, ou null se nenhuma API encontrar. */
    public function consultar(string $cnpj): ?array
    {
        $cnpj = preg_replace('/[^0-9A-Z]/', '', strtoupper($cnpj));

        if (strlen($cnpj) !== 14) {
            return null;
        }

        foreach (self::FONTES as $fonte) {
            $response = $this->requisitar($fonte['url'] . $cnpj);

            if ($response?->getStatusCode() === 404 && $fonte['confirmarNaoEncontrado']) {
                $response = $this->requisitar($fonte['url'] . $cnpj . '?atualizar=' . time());
            }

            if ($response?->getStatusCode() === 200) {
                $dados = json_decode((string) $response->getBody(), true);
                if (is_array($dados)) {
                    return $dados;
                }
            }
        }

        return null;
    }

    /** GET com timeout curto. Retorna null em falha de rede. */
    private function requisitar(string $url): ?ResponseInterface
    {
        try {
            return $this->client->get($url, [
                'timeout' => 5,
                'connect_timeout' => 3,
                'http_errors' => false,
            ]);
        } catch (GuzzleException $e) {
            error_log("CnpjService: falha ao consultar {$url}: " . $e->getMessage());
            return null;
        }
    }
}
