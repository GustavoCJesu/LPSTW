<?php

namespace App\Services;

/** Validação do formulário no servidor (mesmas regras do formulario.js). */
class LeadValidator
{
    /** Pesos dos dígitos verificadores do CNPJ. */
    private const PESOS_DV1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    private const PESOS_DV2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    /** Campo => [rótulo, tamanho máximo]. */
    private const LIMITES = [
        'nome' => ['Nome', 150],
        'cnpj' => ['CNPJ', 18],
        'email' => ['E-mail', 254],
        'telefone' => ['Telefone', 20],
        'colaboradores' => ['Nº de colaboradores', 20],
        'mensagem' => ['Mensagem', 5000],
    ];

    /** Retorna campo => mensagem de erro (vazio se estiver tudo certo). */
    public function validar(array $lead): array
    {
        $erros = array_filter([
            'nome' => $this->nome($lead['nome'] ?? ''),
            'cnpj' => $this->cnpj($lead['cnpj'] ?? ''),
            'email' => $this->email($lead['email'] ?? ''),
        ]);

        foreach (self::LIMITES as $campo => [$rotulo, $maximo]) {
            if (!isset($erros[$campo]) && mb_strlen($lead[$campo] ?? '') > $maximo) {
                $erros[$campo] = "O campo {$rotulo} pode ter no máximo {$maximo} caracteres.";
            }
        }

        return $erros;
    }

    /** Erro do nome ('' se válido). */
    private function nome(string $valor): string
    {
        if ($valor === '') return 'Informe seu nome completo.';
        if (mb_strlen($valor) < 3) return 'O nome deve ter pelo menos 3 letras.';
        return '';
    }

    /** Erro do CNPJ ('' se válido). */
    private function cnpj(string $valor): string
    {
        $codigo = preg_replace('/[^0-9A-Z]/', '', strtoupper($valor));

        if ($codigo === '') return 'Informe o CNPJ da empresa.';
        if (strlen($codigo) < 14) return 'O CNPJ deve ter 14 caracteres.';
        if (!$this->cnpjValido($codigo)) return 'CNPJ inválido. Confira o que foi digitado.';
        return '';
    }

    /** Erro do email ('' se válido). */
    private function email(string $valor): string
    {
        if ($valor === '') return 'Informe seu e-mail corporativo.';
        if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/u', $valor)) {
            return 'Digite um e-mail válido. Ex.: nome@empresa.com.br';
        }
        return '';
    }

    /** Valida o CNPJ (numérico ou alfanumérico). */
    private function cnpjValido(string $codigo): bool
    {
        if (!preg_match('/^[0-9A-Z]{12}\d{2}$/', $codigo) || preg_match('/^(.)\1+$/', $codigo)) {
            return false;
        }

        $dv1 = $this->digitoVerificador($codigo, self::PESOS_DV1);
        $dv2 = $this->digitoVerificador($codigo, self::PESOS_DV2);

        return str_ends_with($codigo, "{$dv1}{$dv2}");
    }

    /** Dígito verificador (módulo 11). */
    private function digitoVerificador(string $codigo, array $pesos): int
    {
        $soma = 0;
        foreach ($pesos as $i => $peso) {
            $soma += (ord($codigo[$i]) - 48) * $peso;
        }

        $resto = $soma % 11;
        return $resto < 2 ? 0 : 11 - $resto;
    }
}
