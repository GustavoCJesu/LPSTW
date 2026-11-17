<?php
// Valores padrão; cada página pode definir antes de incluir o head.
$pagina ??= 'home';
$pageTitle ??= 'STW - Soluções Inteligentes para Gestão de EPIs';
$pageDescription ??= 'Automatize a gestão de EPIs com a STW: armários inteligentes, controle de retiradas em tempo real e software web completo para reduzir desperdícios e garantir conformidade.';
$pagePath ??= '/';
$pageStyles ??= [];

// Fora da home, as âncoras (#form, #products...) apontam para a home.
$prefixoAncora = $pagina === 'home' ? '' : '/';

$pageUrl = SITE_URL . $pagePath;
$logoUrl = SITE_URL . '/images/logo/logo.png';

// Escape para HTML.
$e = fn (string $texto) => htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');

$organizacao = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'STW - Safe to Work',
    'url' => SITE_URL . '/',
    'logo' => $logoUrl,
    'description' => 'Software e máquinas de liberação inteligente de EPIs para sua operação.',
    'email' => 'contato@stw.com.br',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $e($pageTitle) ?></title>
    <meta name="description" content="<?= $e($pageDescription) ?>">
    <meta name="robots" content="index, follow">

    <link rel="canonical" href="<?= $e($pageUrl) ?>">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="STW - Safe to Work">
    <meta property="og:title" content="<?= $e($pageTitle) ?>">
    <meta property="og:description" content="<?= $e($pageDescription) ?>">
    <meta property="og:url" content="<?= $e($pageUrl) ?>">
    <meta property="og:image" content="<?= $e($logoUrl) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= $e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= $e($logoUrl) ?>">

    <meta name="theme-color" content="#1B7A45">

    <link rel="icon" href="/favicon.ico">

    <?php if ($pagina === 'home'): ?>
        <link rel="modulepreload" href="/js/vendor/anime.esm.min.js">
        <script>
            // Esconde os [data-anim] até o JS assumir (mostra tudo em 2,5s se ele não rodar).
            if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.documentElement.classList.add('anim-pendente');
                setTimeout(() => document.documentElement.classList.remove('anim-pendente'), 2500);
            }
        </script>
    <?php endif; ?>

    <link rel="preconnect" href="https://unpkg.com">

    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/hero.css">
    <link rel="stylesheet" href="/css/sobreSTW.css">
    <link rel="stylesheet" href="/css/software.css">
    <link rel="stylesheet" href="/css/produtos.css">
    <?php if (!empty($mostrarDepoimentos)): ?>
        <link rel="stylesheet" href="/css/depoimento.css">
    <?php endif; ?>
    <link rel="stylesheet" href="/css/formulario.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/sobreASW.css">

    <link rel="stylesheet" href="/css/componentsCSS/ctaMobile.css">
    <link rel="stylesheet" href="/css/componentsCSS/modal.css">
    <link rel="stylesheet" href="/css/componentsCSS/cardProduct.css">
    <link rel="stylesheet" href="/css/componentsCSS/numbers.css">
    <link rel="stylesheet" href="/css/componentsCSS/feedbackCard.css">
    <link rel="stylesheet" href="/css/componentsCSS/lightbox.css">

    <?php foreach ($pageStyles as $estilo): ?>
        <link rel="stylesheet" href="<?= $e($estilo) ?>">
    <?php endforeach; ?>

    <script src="https://unpkg.com/lucide@latest"></script>

    <?php if ($pagina === 'home'): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>

    <script type="application/ld+json">
        <?= json_encode($organizacao, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>
    </script>
</head>

<body>
