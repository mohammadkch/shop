<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $homeService;

    public function __construct()
    {
        helper(['menu']);
        $this->homeService = service('homeService');
    }

    public function index(): string
    {
        $homeData = $this->homeService->getHomeData($this->viewData['mediaPath']);

        $this->viewData['stories']    = $homeData['stories'];
        $this->viewData['sliders']    = $homeData['sliders'];
        $this->viewData['categories'] = $homeData['categories'] ?? [];

        return view('home/index', $this->viewData);
    }
}