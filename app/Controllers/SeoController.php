<?php

namespace App\Controllers;

class SeoController
{
    private const PAGINAS = [
        '/' => ['changefreq' => 'monthly', 'priority' => '1.0'],
        '/politica-de-privacidade' => ['changefreq' => 'yearly', 'priority' => '0.3'],
    ];

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=UTF-8');

        echo "User-agent: *\n";
        echo "Allow: /\n\n";
        echo 'Sitemap: ' . SITE_URL . "/sitemap.xml\n";
    }

    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=UTF-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach (self::PAGINAS as $caminho => $info) {
            $loc = htmlspecialchars(SITE_URL . $caminho, ENT_XML1 | ENT_QUOTES, 'UTF-8');

            echo "    <url>\n";
            echo "        <loc>{$loc}</loc>\n";
            echo "        <changefreq>{$info['changefreq']}</changefreq>\n";
            echo "        <priority>{$info['priority']}</priority>\n";
            echo "    </url>\n";
        }

        echo "</urlset>\n";
    }
}
