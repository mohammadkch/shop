<?php

namespace App\Controllers;

class Search extends BaseController
{
    private $searchService;

    public function __construct()
    {
        helper('menu');
        $this->searchService = service('searchService');
    }

    public function index()
    {
        $query = $this->searchService->normalizeQuery($this->request->getGet('q'));
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 12;
        $result = $this->searchService->searchType($query, 'product', $perPage, ($page - 1) * $perPage);

        $this->viewData['query'] = $query;
        $this->viewData['results'] = $result['items'];
        $this->viewData['totalResults'] = $result['total'];
        $this->viewData['pagination'] = $query !== ''
            ? service('pager')->makeLinks($page, $perPage, $result['total'], 'shop_pagination')
            : '';
        $this->viewData['title'] = $query !== '' ? 'نتایج جستجوی «' . $query . '»' : 'جستجوی محصولات';
        $this->viewData['metaDescription'] = 'جستجو در محصولات فروشگاه مومو';
        $this->viewData['robots'] = 'noindex, follow';
        $this->viewData['canonicalUrl'] = site_url('search');

        return view('search/index', $this->viewData);
    }

    public function suggestions()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'درخواست نامعتبر',
            ]);
        }

        $result = $this->searchService->suggestions($this->request->getGet('q'), 6);

        return $this->response->setJSON([
            'status' => 'success',
            'query' => $result['query'],
            'total' => $result['total'],
            'items' => $result['items'],
        ]);
    }
}
