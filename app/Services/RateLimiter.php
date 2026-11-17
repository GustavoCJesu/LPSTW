<?php

namespace App\Services;

/**
 * Limita tentativas por chave (ex.: IP) em uma ou mais janelas de tempo.
 * Guarda os horários em arquivos, sem banco nem extensão extra (serve em hospedagem compartilhada).
 * A chave vira um hash: o IP não fica salvo em texto puro (LGPD).
 */
class RateLimiter
{
    /** Chance de limpar arquivos antigos a cada chamada (1 em N). */
    private const CHANCE_LIMPEZA = 100;

    /**
     * @param array<int, int> $limites segundos da janela => máximo de tentativas nela
     */
    public function __construct(
        private string $pasta,
        private array $limites,
        private string $segredo,
    ) {
    }

    /**
     * Registra uma tentativa. Retorna 0 se liberada, ou quantos segundos faltam para liberar.
     * Tentativas bloqueadas não contam. Se não conseguir gravar, libera (não perde lead por erro de disco).
     */
    public function tentar(string $chave, ?int $agora = null): int
    {
        $agora ??= time();

        if (!is_dir($this->pasta) && !@mkdir($this->pasta, 0700, true) && !is_dir($this->pasta)) {
            error_log("RateLimiter: não foi possível criar {$this->pasta}");
            return 0;
        }

        $arquivo = $this->pasta . '/' . hash_hmac('sha256', $chave, $this->segredo);
        $handle = @fopen($arquivo, 'c+');
        if (!$handle) {
            error_log("RateLimiter: não foi possível abrir {$arquivo}");
            return 0;
        }

        try {
            // Trava o arquivo: requisições simultâneas do mesmo IP esperam a vez.
            flock($handle, LOCK_EX);

            $maiorJanela = max(array_keys($this->limites));
            $horarios = array_filter(
                json_decode(stream_get_contents($handle) ?: '[]', true) ?: [],
                fn ($t) => is_int($t) && $t > $agora - $maiorJanela
            );

            $espera = $this->espera($horarios, $agora);
            if ($espera === 0) {
                $horarios[] = $agora;
                ftruncate($handle, 0);
                rewind($handle);
                fwrite($handle, json_encode(array_values($horarios)));
            }

            return $espera;
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);

            if (random_int(1, self::CHANCE_LIMPEZA) === 1) {
                $this->limparAntigos($agora);
            }
        }
    }

    /** Segundos até liberar, considerando a janela mais restritiva (0 se dentro dos limites). */
    private function espera(array $horarios, int $agora): int
    {
        $espera = 0;

        foreach ($this->limites as $janela => $maximo) {
            $naJanela = array_values(array_filter($horarios, fn ($t) => $t > $agora - $janela));
            sort($naJanela);

            if (count($naJanela) >= $maximo) {
                // Libera quando a tentativa que estourou o limite sair da janela.
                $libera = $naJanela[count($naJanela) - $maximo] + $janela;
                $espera = max($espera, $libera - $agora);
            }
        }

        return $espera;
    }

    /** Apaga arquivos de quem não aparece há mais tempo que a maior janela. */
    private function limparAntigos(int $agora): void
    {
        $limite = $agora - max(array_keys($this->limites));

        foreach (glob($this->pasta . '/*') ?: [] as $arquivo) {
            if (@filemtime($arquivo) < $limite) {
                @unlink($arquivo);
            }
        }
    }
}
