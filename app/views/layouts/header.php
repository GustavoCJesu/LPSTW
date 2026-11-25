<?php /** @var string $prefixoAncora Definida em head.php */ ?>
<header class="header">
    <div class="header__container">
        <a href="/" class="header__logo">
            <img src="/images/logo/logo.png" alt="STW">
        </a>
        <div class="header__mobile">
            <button id="header__btn__menu" class="header__menu-button" aria-label="Abrir menu" aria-expanded="false" aria-controls="menu-mobile">
                <i id="menu-icon--Menu" class="header__menu-icon" data-lucide="menu"></i>
                <i id="menu-icon--X" class="header__menu-icon menu__icon--disabled" data-lucide="x"></i>
            </button>
        </div>
    </div>
    <ul class="header__desktop">
        <li>
            <a class="header__menu-item" href="<?= $prefixoAncora ?>#aboutUs">O que é a STW</a>
        </li>

        <li>
            <a class="header__menu-item" href="<?= $prefixoAncora ?>#software">Plataforma Web</a>
        </li>

        <li>
            <a class="header__menu-item" href="<?= $prefixoAncora ?>#products">Nossos Equipamentos</a>
        </li>

        <li class="header__menu__cta">
            <a href="<?= $prefixoAncora ?>#form">
                Entre em contato!
            </a>
        </li>
    </ul>

    <div class="header__mobile">

        <div class="header__menu" id="menu-mobile">
            <nav class="nav__menu">
                <ul class="header__menu-list">
                    <li class="header__menu-item">
                        <a href="<?= $prefixoAncora ?>#aboutUs">O que é a STW</a>
                    </li>

                    <li class="header__menu-item">
                        <a href="<?= $prefixoAncora ?>#software">Plataforma Web</a>
                    </li>

                    <li class="header__menu-item">
                        <a href="<?= $prefixoAncora ?>#products">Nossos Equipamentos</a>
                    </li>
                </ul>
            </nav>
            <a href="<?= $prefixoAncora ?>#form" class="header__cta">
                Entre em contato!
            </a>
        </div>

    </div>
</header>