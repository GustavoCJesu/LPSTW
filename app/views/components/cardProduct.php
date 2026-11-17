<?php

// Card de produto: imagem, selo, recursos e botão de orçamento.
function ProductCard(array $product, int $id)
{
    $e = fn (string $texto) => htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
?>

    <article class="card">
        <div class="card__vitrine">
            <span class="card__selo"><?= $e($product['selo']) ?></span>
            <img class="card__img" src="<?= $e($product['image']) ?>" alt="<?= $e($product['title']) ?>" loading="lazy" />
        </div>

        <div class="card__corpo">
            <h3 class="card__title"><?= $e($product['title']) ?></h3>
            <p class="card__description"><?= $e($product['description']) ?></p>

            <ul class="card__recursos">
                <?php foreach ($product['topics'] as $i => $topico): ?>
                    <li>
                        <span class="card__recurso__icone"><i data-lucide="<?= $e($product['icons'][$i]) ?>"></i></span>
                        <?= $e($topico) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a class="card__cta__btn" href="#form" data-id="<?= $id ?>">
            Solicitar orçamento <i data-lucide="arrow-right"></i>
        </a>
    </article>

<?php
}
