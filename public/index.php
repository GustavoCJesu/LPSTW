<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\FormReader;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


$uri = $_SERVER['REQUEST_URI'];



switch ($uri) {

    case '/sendForm':
        $form_controller = new FormReader();
        $form_controller->getForm();

        break;
    default:
        $controller = new HomeController();
        $controller->index();
        break;
}
