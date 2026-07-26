<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function __construct()
    {
        helper(['menu']);
    }

    public function index()
    {
        $this->viewData['title'] = 'تماس با ما | مومو';

        // ========== اطلاعات تماس ==========
        $contactInfo = [
            [
                'icon'  => 'location',
                'title' => 'آدرس تهران',
                'value' => 'تهران - هروی - مجتمع رونیکا مال - طبقه همکف پلاک ۶۹',
            ],
            [
                'icon'  => 'location',
                'title' => 'آدرس بندر انزلی',
                'value' => 'بندر انزلی - مجتمع انزل مال - پلاک ۹۵',
            ],
            [
                'icon'  => 'phone',
                'title' => 'تلفن تماس',
                'value' => '۰۹۱۰۲۰۴۶۱۴۴',
            ],
            [
                'icon'  => 'email',
                'title' => 'ایمیل',
                'value' => 'info@momomod.ir<br>support@momomod.ir',
            ],
        ];

        // ========== اطلاعات نقشه ==========
        $mapData = [
            'lat' => '35.7783693',
            'lng' => '51.4800463',
            'zoom' => '276m',
        ];

        $this->viewData['contactInfo'] = $contactInfo;
        $this->viewData['mapData']     = $mapData;
        $this->viewData['assetsPath']  = base_url('assets/');

        return view('contact/index', $this->viewData);
    }
}