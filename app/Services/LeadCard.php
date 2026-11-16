<?php

namespace App\Services;

use DateTime;
use DateTimeZone;

class LeadCard
{
    private const MAX_SOCIOS = 5;

    private const PORTES = [
        'DEMAIS' => 'Médio/Grande porte',
        'MICRO EMPRESA' => 'Microempresa (ME)',
        'EMPRESA DE PEQUENO PORTE' => 'Empresa de pequeno porte (EPP)',
    ];

    private array $lead;
    private ?array $empresa;

    public function __construct(array $lead, ?array $empresa)
    {
        $this->lead = $lead;
        $this->empresa = $empresa;
    }

    public function titulo(): string
    {
        $titulo = 'Lead - ' . ($this->lead['nome'] ?: 'Não informado');
        $nomeEmpresa = $this->campo('nome_fantasia') ?: $this->campo('razao_social');

        return $nomeEmpresa ? "{$titulo} | {$nomeEmpresa}" : $titulo;
    }

    public function descricao(): string
    {
        return implode("\n\n", [
            $this->secaoContato(),
            $this->secaoEmpresa(),
            $this->secaoMensagem(),
            "---\n_Lead recebido pelo site em {$this->agora()}._",
        ]);
    }

    private function secaoContato(): string
    {
        return $this->secao('👤 Contato', [
            'Nome' => $this->lead['nome'] ?: 'Não informado',
            'Email' => $this->lead['email'] ?: 'Não informado',
            'Telefone' => $this->lead['telefone'] ?: 'Não informado',
            'Nº de colaboradores' => $this->lead['colaboradores'] ?: 'Não informado',
        ]);
    }

    private function secaoEmpresa(): string
    {
        $cnpj = $this->formatarCnpj($this->lead['cnpj']);

        if (!$this->empresa) {
            return $this->secao('🏢 Empresa', ['CNPJ' => $cnpj ?: 'Não informado'])
                . "\n\n_Não foi possível consultar os dados deste CNPJ na Receita Federal._";
        }

        $tipo = $this->campo('descricao_identificador_matriz_filial');

        $texto = $this->secao('🏢 Empresa', [
            'CNPJ' => $tipo ? $cnpj . ' (' . ucfirst(strtolower($tipo)) . ')' : $cnpj,
            'Razão social' => $this->campo('razao_social'),
            'Nome fantasia' => $this->campo('nome_fantasia'),
            'Situação cadastral' => $this->situacao(),
            'Porte' => $this->porte(),
            'Capital social' => $this->capitalSocial(),
            'Atividade principal' => $this->atividadePrincipal(),
            'Abertura' => $this->abertura(),
            'Endereço' => $this->endereco(),
            'Telefone (Receita)' => $this->telefonesReceita(),
            'Email (Receita)' => strtolower($this->campo('email')),
        ]);

        $socios = $this->socios();
        if ($socios) {
            $texto .= "\n\n**Sócios e administradores**\n{$socios}";
        }

        return $texto;
    }

    private function secaoMensagem(): string
    {
        $mensagem = trim(str_replace("\r\n", "\n", $this->lead['mensagem']));

        if ($mensagem === '') {
            return "## 💬 Mensagem\n_Sem mensagem._";
        }

        return "## 💬 Mensagem\n> " . str_replace("\n", "\n> ", $mensagem);
    }

    private function secao(string $titulo, array $campos): string
    {
        $linhas = ["## {$titulo}"];

        foreach ($campos as $rotulo => $valor) {
            if ($valor !== '') {
                $linhas[] = "- **{$rotulo}:** {$valor}";
            }
        }

        return implode("\n", $linhas);
    }

    private function campo(string $chave): string
    {
        return trim((string) ($this->empresa[$chave] ?? ''));
    }

    private function situacao(): string
    {
        $situacao = $this->campo('descricao_situacao_cadastral');

        if ($situacao === '' || $situacao === 'ATIVA') {
            return $situacao ? "✅ {$situacao}" : '';
        }

        $desde = $this->formatarData($this->campo('data_situacao_cadastral'));
        return "⚠️ **{$situacao}**" . ($desde ? " desde {$desde}" : '');
    }

    private function porte(): string
    {
        $porte = $this->campo('porte');
        return self::PORTES[$porte] ?? $porte;
    }

    private function capitalSocial(): string
    {
        $capital = $this->empresa['capital_social'] ?? null;

        if (!is_numeric($capital) || $capital <= 0) {
            return '';
        }

        return 'R$ ' . number_format((float) $capital, 2, ',', '.');
    }

    private function atividadePrincipal(): string
    {
        $descricao = $this->campo('cnae_fiscal_descricao');
        $codigo = preg_replace('/\D/', '', $this->campo('cnae_fiscal'));

        if ($codigo === '') {
            return $descricao;
        }

        $codigo = str_pad($codigo, 7, '0', STR_PAD_LEFT);
        $codigo = substr($codigo, 0, 4) . '-' . substr($codigo, 4, 1) . '/' . substr($codigo, 5, 2);

        return $descricao ? "{$descricao} (CNAE {$codigo})" : "CNAE {$codigo}";
    }

    private function abertura(): string
    {
        $data = $this->campo('data_inicio_atividade');
        $formatada = $this->formatarData($data);

        if (!$formatada) {
            return '';
        }

        $anos = (new DateTime($data))->diff(new DateTime('today'))->y;
        $idade = match (true) {
            $anos < 1 => 'menos de 1 ano',
            $anos === 1 => '1 ano',
            default => "{$anos} anos",
        };

        return "{$formatada} ({$idade})";
    }

    private function endereco(): string
    {
        $rua = trim($this->campo('descricao_tipo_de_logradouro') . ' ' . $this->campo('logradouro'));
        $rua = implode(', ', array_filter([$rua, $this->campo('numero')]));

        $cidade = implode('/', array_filter([$this->campo('municipio'), $this->campo('uf')]));

        $cep = preg_replace('/\D/', '', $this->campo('cep'));
        $cep = strlen($cep) === 8 ? 'CEP ' . substr($cep, 0, 5) . '-' . substr($cep, 5) : '';

        return implode(' - ', array_filter([
            $rua,
            $this->campo('complemento'),
            $this->campo('bairro'),
            $cidade,
            $cep,
        ]));
    }

    private function telefonesReceita(): string
    {
        $telefones = array_map(
            fn ($chave) => $this->formatarTelefone($this->campo($chave)),
            ['ddd_telefone_1', 'ddd_telefone_2']
        );

        return implode(' / ', array_filter($telefones));
    }

    private function socios(): string
    {
        $qsa = $this->empresa['qsa'] ?? [];

        if (!is_array($qsa) || !$qsa) {
            return '';
        }

        $linhas = [];
        foreach (array_slice($qsa, 0, self::MAX_SOCIOS) as $socio) {
            $nome = trim($socio['nome_socio'] ?? '');
            $cargo = trim($socio['qualificacao_socio'] ?? '');

            if ($nome !== '') {
                $linhas[] = '- ' . ($cargo ? "{$nome} — {$cargo}" : $nome);
            }
        }

        $restantes = count($qsa) - self::MAX_SOCIOS;
        if ($restantes > 0) {
            $linhas[] = "- _e mais {$restantes}_";
        }

        return implode("\n", $linhas);
    }

    private function formatarCnpj(string $cnpj): string
    {
        $codigo = preg_replace('/[^0-9A-Z]/', '', strtoupper($cnpj));

        if (strlen($codigo) !== 14) {
            return trim($cnpj);
        }

        return substr($codigo, 0, 2) . '.' . substr($codigo, 2, 3) . '.' . substr($codigo, 5, 3)
            . '/' . substr($codigo, 8, 4) . '-' . substr($codigo, 12, 2);
    }

    private function formatarTelefone(string $telefone): string
    {
        $numero = preg_replace('/\D/', '', $telefone);

        return match (strlen($numero)) {
            10 => '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6),
            11 => '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7),
            default => $numero,
        };
    }

    private function formatarData(string $data): string
    {
        $dataHora = DateTime::createFromFormat('!Y-m-d', $data);
        return $dataHora ? $dataHora->format('d/m/Y') : '';
    }

    private function agora(): string
    {
        $agora = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        return $agora->format('d/m/Y') . ' às ' . $agora->format('H:i');
    }
}
