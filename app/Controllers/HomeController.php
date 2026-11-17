<?php
namespace App\Controllers;

/** Páginas do site. */
class HomeController
{
    /** Página inicial. */
    public function index()
    {
        require_once __DIR__ . '/../views/home/index.php';
    }

    /** Política de privacidade. */
    public function privacidade()
    {
        require_once __DIR__ . '/../views/privacidade/index.php';
    }
}
