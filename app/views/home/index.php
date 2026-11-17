<?php
// Depoimentos fora da página até a seção ficar pronta (true para mostrar).
$mostrarDepoimentos = false;

require_once __DIR__ . '/../layouts/head.php';
require_once __DIR__ . '/../layouts/header.php';
?>
<main>
    <?php
    require_once __DIR__ . '/../layouts/hero.php';
    ?>
    <div>
        <?php
        require_once __DIR__ . '/../layouts/sobreASW.php';
        ?>
    </div>
    
    <?php
    require_once __DIR__ . '/../layouts/sobreSTW.php';
    require_once __DIR__ . '/../components/numbers.php';
    require_once __DIR__ . '/../layouts/software.php';
    require_once __DIR__ . '/../components/modal.php';
    require_once __DIR__ . '/../layouts/produtos.php';
    if ($mostrarDepoimentos) {
        require_once __DIR__ . '/../layouts/depoimentos.php';
    }
    require_once __DIR__ . '/../layouts/formulario.php';
    require_once __DIR__ . '/../components/feedbackCard.php';
    require_once __DIR__ . '/../components/lightbox.php';
    ?>
</main>
<?php
require_once __DIR__ . '/../layouts/footer.php';

?>