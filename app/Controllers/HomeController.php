<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../views/home/index.php';
    }

    public function privacidade()
    {
        require_once __DIR__ . '/../views/privacidade/index.php';
    }
}
