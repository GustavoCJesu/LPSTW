<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FormReader;
use App\Controllers\HomeController;
use App\Controllers\SeoController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Endereço público do site, usado no canonical, nas tags de compartilhamento,
// no robots.txt e no sitemap. Defina APP_URL no .env (ex.: https://www.stw.com.br);
// sem ele, usa o domínio pelo qual o site foi acessado.
$siteUrl = $_ENV['APP_URL'] ?? '';
if ($siteUrl === '') {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    $siteUrl = ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
}
define('SITE_URL', rtrim($siteUrl, '/'));

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

switch ($path) {
    case '/sendForm':
        (new FormReader())->getForm();
        break;

    case '/politica-de-privacidade':
        (new HomeController())->privacidade();
        break;

    case '/robots.txt':
        (new SeoController())->robots();
        break;

    case '/sitemap.xml':
        (new SeoController())->sitemap();
        break;

    default:
        (new HomeController())->index();
        break;
}
