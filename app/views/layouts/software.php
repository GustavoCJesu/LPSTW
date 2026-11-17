<?php
// Módulos mostrados na seção. A ordem define a sequência do avanço automático (software.js).
$modulos = [
    [
        'titulo' => 'Início',
        'icone' => 'house',
        'imagem' => '/images/inicio.webp',
        'alt' => 'Tela inicial do software STW com resumo da operação',
        'descricao' => 'Tenha um resumo completo da operação assim que acessa o sistema: retiradas, requisições e alertas importantes, como EPIs vencendo ou equipamentos desconectados, com acesso rápido aos principais módulos.',
    ],
    [
        'titulo' => 'GHE',
        'icone' => 'users',
        'imagem' => '/images/ghe.webp',
        'alt' => 'Tela de Grupos Homogêneos de Exposição do software STW',
        'descricao' => 'Configure os Grupos Homogêneos de Exposição e defina quais EPIs cada categoria pode utilizar, com regras de quantidade, período de uso e alertas de vencimento personalizados por grupo.',
    ],
    [
        'titulo' => 'Relatórios',
        'icone' => 'file-text',
        'imagem' => '/images/relatorios.webp',
        'alt' => 'Tela de relatórios do software STW',
        'descricao' => 'Acesse um catálogo completo de relatórios: retiradas, saldos, vencimentos e pendências por colaborador, além de entregas por responsável e abastecimento das máquinas.',
    ],
    [
        'titulo' => 'Dashboard',
        'icone' => 'layout-dashboard',
        'imagem' => '/images/dashboard.webp',
        'alt' => 'Dashboard do software STW com gráficos de consumo',
        'descricao' => 'Acompanhe indicadores em tempo real com gráficos de consumo, comparativos entre períodos e alertas críticos, como CAs vencidos e colaboradores com EPI vencido, filtrando por empresa e período.',
    ],
    [
        'titulo' => 'Registro',
        'icone' => 'clipboard-list',
        'imagem' => '/images/registro.webp',
        'alt' => 'Tela de registro de retiradas do software STW',
        'descricao' => 'Registre e acompanhe cada retirada e requisição de EPI em tempo real, com histórico detalhado por colaborador, produto e data, além de estatísticas como variação mensal e pendências.',
    ],
];
?>
<section id="software" class="software__container">
    <div class="software__cabecalho" data-anim-grupo="sobe">
        <h2 class="software__section__title section-heading">CONHEÇA NOSSO <span class="destaque">SOFTWARE WEB!</span></h2>
        <p class="software__section__description">Gerencie EPIs com mais segurança, agilidade e controle em uma única plataforma.</p>
    </div>

    <div class="software__conteudo">
        <!-- Janela do sistema: as telas ficam empilhadas e a ativa aparece por cima -->
        <figure class="software__janela" data-anim="zoom">
            <div class="software__janela__barra" aria-hidden="true">
                <span class="software__janela__bolinhas"><i></i><i></i><i></i></span>
                <span class="software__janela__rotulo">Safe to Work · <span class="software__janela__modulo"><?= $modulos[0]['titulo'] ?></span></span>
            </div>
            <div class="software__telas">
                <?php foreach ($modulos as $i => $modulo): ?>
                    <img class="software__tela js-expandable<?= $i === 0 ? ' software__tela--ativa' : '' ?>"
                        src="<?= $modulo['imagem'] ?>" alt="<?= $modulo['alt'] ?>"
                        width="1024" height="534" <?= $i === 0 ? '' : 'loading="lazy"' ?> />
                <?php endforeach; ?>
            </div>
        </figure>

        <div class="software__lateral">
            <ul class="software__modulos" data-anim-grupo="sobe">
                <?php foreach ($modulos as $i => $modulo): ?>
                    <li class="software__modulo<?= $i === 0 ? ' software__modulo--ativo' : '' ?>">
                        <button class="software__modulo__botao" type="button"
                            aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="software-modulo-<?= $i ?>">
                            <span class="software__modulo__icone"><i data-lucide="<?= $modulo['icone'] ?>"></i></span>
                            <span class="software__modulo__titulo"><?= $modulo['titulo'] ?></span>
                        </button>
                        <div class="software__modulo__texto" id="software-modulo-<?= $i ?>">
                            <div><p><?= $modulo['descricao'] ?></p></div>
                        </div>
                        <span class="software__progresso" aria-hidden="true"><span></span></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php $text = "Solicitar um orçamento!";
            $link = "#leadForm";
            require __DIR__ . "/../components/ctaMobile.php" ?>
        </div>
    </div>
</section>
