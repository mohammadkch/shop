<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class Sitemap extends Controller
{
    public function index(): ResponseInterface
    {
        $sitemaps = [
            site_url('sitemap-products.xml'),
            site_url('sitemap-categories.xml'),
            site_url('sitemap-blog.xml'),
            site_url('sitemap-pages.xml'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($sitemaps as $sitemap) {
            $xml .= '<sitemap><loc>' . $this->escape($sitemap) . '</loc></sitemap>';
        }
        $xml .= '</sitemapindex>';

        return $this->xml($xml);
    }

    public function products(): ResponseInterface
    {
        helper('product');

        $products = model('App\Models\ProductModel')
            ->select('id, slug, created_at, updated_at')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->findAll();

        $urls = [];
        foreach ($products as $product) {
            $urls[] = [
                'loc' => product_url($product),
                'lastmod' => $this->lastmod(($product['updated_at'] ?? null) ?: ($product['created_at'] ?? null)),
            ];
        }

        return $this->urlSet($urls);
    }

    public function categories(): ResponseInterface
    {
        $db = db_connect();
        $urls = [];

        $allProductsPage = model('App\Models\AllProductsPageModel')->find(1);
        $urls[] = [
            'loc' => site_url('category'),
            'lastmod' => $this->lastmod(($allProductsPage['updated_at'] ?? null) ?: ($allProductsPage['created_at'] ?? null)),
        ];

        $menu1Rows = $db->table('menu_1')
            ->select('id, slug, created_at, updated_at')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
        foreach ($menu1Rows as $menu1) {
            $urls[] = [
                'loc' => site_url('category/' . $menu1['slug']),
                'lastmod' => $this->lastmod($this->latestTimestamp($menu1)),
            ];
        }

        $menu2Rows = $db->table('menu_2 AS m2')
            ->select('m2.slug, m2.created_at, m2.updated_at, m1.slug AS menu1_slug, m1.created_at AS menu1_created_at, m1.updated_at AS menu1_updated_at')
            ->join('menu_1 AS m1', 'm1.id = m2.menu_1_id')
            ->where('m2.is_active', 1)
            ->where('m2.is_visible', 1)
            ->where('m1.is_active', 1)
            ->orderBy('m2.id', 'ASC')
            ->get()->getResultArray();
        foreach ($menu2Rows as $menu2) {
            $urls[] = [
                'loc' => site_url('category/' . $menu2['menu1_slug'] . '/' . $menu2['slug']),
                'lastmod' => $this->lastmod($this->latestTimestamp($menu2)),
            ];
        }

        $menu3Rows = $db->table('menu_3 AS m3')
            ->select('m3.slug, m3.created_at, m3.updated_at, m2.slug AS menu2_slug, m2.created_at AS menu2_created_at, m2.updated_at AS menu2_updated_at, m1.slug AS menu1_slug, m1.created_at AS menu1_created_at, m1.updated_at AS menu1_updated_at')
            ->join('menu_2 AS m2', 'm2.id = m3.menu_2_id')
            ->join('menu_1 AS m1', 'm1.id = m2.menu_1_id')
            ->where('m3.is_active', 1)
            ->where('m3.is_visible', 1)
            ->where('m2.is_active', 1)
            ->where('m2.is_visible', 1)
            ->where('m1.is_active', 1)
            ->orderBy('m3.id', 'ASC')
            ->get()->getResultArray();
        foreach ($menu3Rows as $menu3) {
            $urls[] = [
                'loc' => site_url('category/' . $menu3['menu1_slug'] . '/' . $menu3['menu2_slug'] . '/' . $menu3['slug']),
                'lastmod' => $this->lastmod($this->latestTimestamp($menu3)),
            ];
        }

        return $this->urlSet($urls);
    }

    public function blog(): ResponseInterface
    {
        $posts = model('App\Models\BlogPostModel')->publicBuilder()
            ->orderBy('post.id', 'ASC')
            ->get()->getResultArray();

        $urls = [['loc' => site_url('blog'), 'lastmod' => null]];
        foreach ($posts as $post) {
            $location = $this->blogCanonical($post);
            if ($location === null) {
                continue;
            }

            $urls[] = [
                'loc' => $location,
                'lastmod' => $this->lastmod(($post['updated_at'] ?? null) ?: ($post['published_at'] ?? null)),
            ];
        }

        return $this->urlSet($urls);
    }

    public function pages(): ResponseInterface
    {
        return $this->urlSet(array_map(
            static fn(string $path): array => ['loc' => site_url($path), 'lastmod' => null],
            ['', 'about', 'contact', 'faq', 'customer-support']
        ));
    }

    public function legacyBlog(): ResponseInterface
    {
        return redirect()->to(site_url('sitemap-blog.xml'))->setStatusCode(301);
    }

    private function blogCanonical(array $post): ?string
    {
        $standardUrl = site_url('blog/' . $post['slug']);
        $canonical = trim((string) ($post['canonical_url'] ?? ''));
        if ($canonical === '') {
            return $standardUrl;
        }

        if (str_starts_with($canonical, '/')) {
            $canonical = site_url(ltrim($canonical, '/'));
        }

        $siteHost = strtolower((string) parse_url(site_url('/'), PHP_URL_HOST));
        $canonicalHost = strtolower((string) parse_url($canonical, PHP_URL_HOST));
        if ($canonicalHost === '' || $canonicalHost !== $siteHost) {
            return null;
        }

        $canonicalPath = rtrim((string) parse_url($canonical, PHP_URL_PATH), '/');
        $standardPath = rtrim((string) parse_url($standardUrl, PHP_URL_PATH), '/');

        return $canonicalPath === $standardPath ? $canonical : $standardUrl;
    }

    private function latestTimestamp(array $row): ?int
    {
        $timestamps = [];
        foreach ($row as $key => $value) {
            if (($key === 'created_at' || $key === 'updated_at' || str_ends_with($key, '_created_at') || str_ends_with($key, '_updated_at')) && $value) {
                $timestamps[] = (int) $value;
            }
        }

        return $timestamps ? max($timestamps) : null;
    }

    private function lastmod(mixed $timestamp): ?string
    {
        $timestamp = (int) $timestamp;
        return $timestamp > 0 ? gmdate('c', $timestamp) : null;
    }

    private function urlSet(array $urls): ResponseInterface
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . $this->escape($url['loc']) . '</loc>';
            if (!empty($url['lastmod'])) {
                $xml .= '<lastmod>' . $this->escape($url['lastmod']) . '</lastmod>';
            }
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        return $this->xml($xml);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private function xml(string $body): ResponseInterface
    {
        return $this->response
            ->setContentType('application/xml', 'UTF-8')
            ->setBody($body);
    }
}
