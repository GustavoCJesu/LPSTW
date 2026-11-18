<?php

$products = [
    [
        "title" => "Balcão de Atendimento",
        "selo" => "Atendimento assistido",
        "description" => "Centralize a distribuição de EPIs em um ponto de atendimento com gestão completa de estoque e colaboradores.",
        "topics" => [
            "Atendimento com operador",
            "Gestão completa do estoque",
            "Controle por colaborador",
            "Ideal para centralizar a entrega"
        ],
        "icons" => [
            "monitor",
            "package",
            "user-check",
            "store"
        ],
        "image" => "/images/maquinas/Balcao.png"
    ],
    [
        "title" => "Dispenser 36 Slots",
        "selo" => "Atendimento automático",
        "description" => "Distribua EPIs automaticamente em até 36 compartimentos individuais, com liberação rápida e sem intervenção manual.",
        "topics" => [
            "Liberação automática",
            "36 compartimentos individuais",
            "Controle por colaborador",
            "Ideal para médio porte"
        ],
        "icons" => [
            "unlock",
            "layout-grid",
            "user-check",
            "building"
        ],
        "image" => "/images/maquinas/Dispenser36.png"
    ],
    [
        "title" => "Dispenser 60 Slots",
        "selo" => "Atendimento automático",
        "description" => "Versão de maior capacidade, com 60 compartimentos para atender operações de grande porte com máxima disponibilidade de EPIs.",
        "topics" => [
            "Liberação automática",
            "60 compartimentos individuais",
            "Controle por colaborador",
            "Ideal para grande porte"
        ],
        "icons" => [
            "unlock",
            "layout-grid",
            "user-check",
            "factory"
        ],
        "image" => "/images/maquinas/Dispenser60.png"
    ],
    [
        "title" => "Locker Inteligente",
        "selo" => "Atendimento automático",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Liberação automática",
            "Portas individuais",
            "Controle por colaborador",
            "Ideal para operação 24 horas"
        ],
        "icons" => [
            "unlock",
            "door-closed",
            "user-check",
            "clock"
        ],
        "image" => "/images/maquinas/Locker.png"
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
        <button data-id='0' class="product__single__brt">
            <i data-lucide="ChevronLeft"></i>
        </button>
        <button data-id='1' class="product__single__brt">
            <i data-lucide="ChevronRight"></i>
        </button>
    </div>
    <?php $text = 'Se interessou? Contate-nos!'; $link = '#form' ; require __DIR__ . '/../components/ctaMobile.php' ?>
</section>