<?php

$products = [
    [
        "title" => "Locker Inteligente",
        "selo" => "24 horas",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Entrega automatizada de EPIs",
            "Controle por colaborador",
            "Registro de retiradas",
            "Funcionamento 24 horas"
        ],
        "icons" => [
            "package-check",
            "user-check",
            "clipboard-list",
            "clock"
        ],
        "image" => "/images/maquinas/Locker.png"
    ],
    [
        "title" => "Balcão de Atendimento",
        "selo" => "Atendimento assistido",
        "description" => "Centralize a distribuição de EPIs em um ponto de atendimento com gestão completa de estoque e colaboradores.",
        "topics" => [
            "Atendimento assistido via terminal",
            "Gestão completa de estoque",
            "Cadastro de colaboradores autorizados",
            "Conformidade com normas de segurança"
        ],
        "icons" => [
            "monitor",
            "package",
            "users",
            "shield-check"
        ],
        "image" => "/images/maquinas/Balcao.png"
    ],
    [
        "title" => "Dispenser 36 Slots",
        "selo" => "36 slots",
        "description" => "Distribua EPIs automaticamente em até 36 compartimentos individuais, com liberação rápida e sem intervenção manual.",
        "topics" => [
            "36 compartimentos individuais",
            "Liberação automática",
            "Ideal para operações de médio porte",
            "Monitoramento remoto"
        ],
        "icons" => [
            "layout-grid",
            "unlock",
            "building",
            "wifi"
        ],
        "image" => "/images/maquinas/Dispenser36.png"
    ],
    [
        "title" => "Dispenser 60 Slots",
        "selo" => "60 slots",
        "description" => "Versão de maior capacidade, com 60 compartimentos para atender operações de grande porte com máxima disponibilidade de EPIs.",
        "topics" => [
            "60 compartimentos individuais",
            "Alta capacidade de armazenamento",
            "Liberação automática",
            "Monitoramento remoto"
        ],
        "icons" => [
            "layout-grid",
            "package",
            "unlock",
            "wifi"
        ],
        "image" => "/images/maquinas/Dispenser60.png"
    ],
];

require_once __DIR__ . "/../components/cardProduct.php"

?>

<section id="products" class="products">
    <div class="products__title" data-anim-grupo="sobe">
        <h2 class="section-heading">
            Quais são os <span class="destaque">nossos equipamentos?</span>
        </h2>
        <p class="section-subtitle">
            Com os equipamentos da STW, cada colaborador retira o EPI de que precisa de forma rápida e segura, enquanto você acompanha cada entrega e mantém a operação em conformidade.
        </p>
    </div>
    <div class="product__list" data-anim-grupo="sobe">
        <?php
        $id = 0;
        foreach ($products as $product): ?>
            <div class="products__card">
                <?php ProductCard($product, $id);
                $id++; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="product__btns">
        <button data-id='0' class="product__single__brt"><i data-lucide="ChevronLeft"></i></button>
        <button data-id='1' class="product__single__brt"><i data-lucide="ChevronRight"></i></button>
    </div>
    <?php $text = 'Se interessou? Contate-nos!'; $link = '#form' ; require __DIR__ . '/../components/ctaMobile.php' ?>
</section>