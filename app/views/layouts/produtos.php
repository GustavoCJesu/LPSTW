<?php

$products = [
    [
        "title" => "Armário Inteligente",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Entrega automatizada de EPIs",
            "Controle por colaborador",
            "Registro de retiradas",
            "Redução de processos manuais"
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
        "title" => "Armário Inteligente",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Entrega automatizada de EPIs",
            "Controle por colaborador",
            "Registro de retiradas",
            "Redução de processos manuais"
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
        "title" => "Armário Inteligente",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Entrega automatizada de EPIs",
            "Controle por colaborador",
            "Registro de retiradas",
            "Redução de processos manuais"
        ],
        "icons" => [
            "package-check",
            "user-check",
            "clipboard-list",
            "clock"
        ],
        "image" => "/images/maquinas/Dispenser.png"
    ],
    [
        "title" => "Armário Inteligente",
        "description" => "Automatize a entrega de EPIs com controle total sobre retiradas, colaboradores autorizados e histórico de utilização.",
        "topics" => [
            "Entrega automatizada de EPIs",
            "Controle por colaborador",
            "Registro de retiradas",
            "Redução de processos manuais"
        ],
        "icons" => [
            "package-check",
            "user-check",
            "clipboard-list",
            "clock"
        ],
        "image" => "/images/maquinas/Dispenser.png"
    ],
];

require_once __DIR__ . "/../components/cardProduct.php"

?>

<section id="products" class="products">
    <div class="products__title">
        <h1>
            QUAIS SÃO OS <span class="destaque">NOSSO PRODUTOS?</span>
        </h1>
        <p>
            Conheça as soluções da STW
        </p>
    </div>
    <div class="product__list">
        <?php foreach ($products as $product): ?>
            <div class="products__card">
                <?php ProductCard($product) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="product__btns">
        <button data-id='0' class="product__single__brt"><i data-lucide="ChevronLeft"></i></button>
        <button data-id='1' class="product__single__brt"><i data-lucide="ChevronRight"></i></button>
    </div>
    
</section>