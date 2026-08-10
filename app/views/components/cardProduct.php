<?php

function ProductCard(array $product, int $id)
{
?>

    <div class="card">
        <div>
            <h3 class="card__title">
                <?= $product['title'] ?>
            </h3>
            <p class="card__description">
                <?= $product['description'] ?>
            </p>
        </div>
        <div class="card__description__topics">
            <div class="card__container__img">
                <img class="card__img js-expandable" src="<?= $product['image'] ?>" alt="<?= $product['title'] ?>" />
            </div>
            <div class="card__list__topics">
                <ul>
                    <li><i class="card__icon" data-lucide="<?= $product['icons'][0] ?>"></i>
                        <p class="card__icon__description"><?= $product['topics'][0] ?></p>
                    </li>
                    <li><i class="card__icon" data-lucide="<?= $product['icons'][1] ?>"></i>
                        <p class="card__icon__description"><?= $product['topics'][1] ?></p>
                    </li>
                    <li><i class="card__icon" data-lucide="<?= $product['icons'][2] ?>"></i>
                        <p class="card__icon__description"><?= $product['topics'][2] ?></p>
                    </li>
                    <li><i class="card__icon" data-lucide="<?= $product['icons'][3] ?>"></i>
                        <p class="card__icon__description"><?= $product['topics'][3] ?></p>
                    </li>

                </ul>

            </div>
        </div>
        <div class="card__cta">
            <a class="card__cta__btn" href="#leadForm" data-id="<?= $id ?>">Solicitar um orçamento</a><i data-lucide="ChevronRight"></i>
        </div>
    </div>

<?php
}
