<?php

namespace App\Controllers\Admin;

class ProductMenu3 extends BaseController
{
    public function manage($productId)
    {
        $productId = (int) $productId;

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $menu1Model = model('App\Models\Menu1Model');
        $menu1List = $menu1Model->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        $productMenuModel = model('App\Models\ProductMenuModel');
        $productMenus = $productMenuModel
            ->select('product_menu.*, menu_3.name as menu_3_name, menu_3.menu_2_id, menu_2.menu_1_id, menu_1.name as menu_1_name, menu_2.name as menu_2_name')
            ->join('menu_3', 'menu_3.id = product_menu.menu_3_id')
            ->join('menu_2', 'menu_2.id = menu_3.menu_2_id')
            ->join('menu_1', 'menu_1.id = menu_2.menu_1_id')
            ->where('product_menu.product_id', $productId)
            ->findAll();

        $this->viewData['product'] = $product;
        $this->viewData['product_id'] = $productId;
        $this->viewData['productMenus'] = $productMenus;
        $this->viewData['menu1List'] = $menu1List;
        $this->viewData['title'] = 'مدیریت منوهای محصول - ' . $product['name'];

        return view('admin/product_menu3/manage', $this->viewData);
    }

    public function getMenu2($menu1Id)
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model
            ->where('menu_1_id', $menu1Id)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $menus2
        ]);
    }

    public function getMenu3($menu2Id)
    {
        $menu3Model = model('App\Models\Menu3Model');
        $menus3 = $menu3Model
            ->where('menu_2_id', $menu2Id)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $menus3
        ]);
    }

    public function update($productMenuId)
    {
        $productMenuModel = model('App\Models\ProductMenuModel');
        $productMenu = $productMenuModel->find($productMenuId);

        if (!$productMenu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رکورد یافت نشد'
            ]);
        }

        $menu3Id = (int) $this->request->getPost('menu3_id');

        if ($menu3Id < 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو سطح 3 معتبر نیست'
            ]);
        }

        // چک کن که این منو قبلاً به این محصول متصل نشده باشه (به جز خودش)
        $exists = $productMenuModel
            ->where('product_id', $productMenu['product_id'])
            ->where('menu_3_id', $menu3Id)
            ->where('id !=', $productMenuId)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'این منو قبلاً به این محصول متصل شده است'
            ]);
        }

        // آپدیت رکورد
        if ($productMenuModel->update($productMenuId, ['menu_3_id' => $menu3Id])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'منو با موفقیت به‌روزرسانی شد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در به‌روزرسانی'
            ]);
        }
    }

    public function delete($id)
    {
        $productMenuModel = model('App\Models\ProductMenuModel');
        $productMenu = $productMenuModel->find($id);

        if (!$productMenu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رکورد یافت نشد'
            ]);
        }

        if ($productMenuModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'اتصال منو با موفقیت حذف شد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف'
            ]);
        }
    }

    public function create($productId)
    {
        $productId = (int) $productId;

        // بررسی وجود محصول
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        // اگه درخواست POST بود، بره به formHandler
        if ($this->request->getMethod() === 'POST') {
            return $this->formHandler($productId);
        }

        // دریافت منوهای سطح 1 (همه)
        $menu1Model = model('App\Models\Menu1Model');
        $menu1List = $menu1Model->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        // منوهای سطح 2 (خالی برای شروع)
        $menu2List = [];

        // منوهای سطح 3 (خالی برای شروع)
        $menu3List = [];

        $this->viewData['product'] = $product;
        $this->viewData['product_id'] = $productId;
        $this->viewData['menu1List'] = $menu1List;
        $this->viewData['menu2List'] = $menu2List;
        $this->viewData['menu3List'] = $menu3List;
        $this->viewData['title'] = 'افزودن منو به محصول - ' . $product['name'];
        $this->viewData['form_action'] = 'admin/product-menu3/create/' . $productId;

        return view('admin/product_menu3/create', $this->viewData);
    }

    public function formHandler($productId)
    {
        $productId = (int) $productId;

        // بررسی وجود محصول
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        // دریافت منوی سطح 3 از POST (اسم درست = menu_3_id)
        $menu3Id = (int) $this->request->getPost('menu_3_id');

        if ($menu3Id < 1) {
            $this->flash('validation_error', 'لطفاً یک منوی سطح 3 انتخاب کنید');
            return redirect()->to('admin/product-menu3/create/' . $productId);
        }

        // بررسی اینکه آیا این منو قبلاً به این محصول متصل شده است
        $productMenuModel = model('App\Models\ProductMenuModel');
        $exists = $productMenuModel
            ->where('product_id', $productId)
            ->where('menu_3_id', $menu3Id)
            ->first();

        if ($exists) {
            $this->flash('validation_error', 'این منو قبلاً به این محصول متصل شده است');
            return redirect()->to('admin/product-menu3/create/' . $productId);
        }

        // ذخیره اتصال جدید
        $productMenuModel->insert([
            'product_id' => $productId,
            'menu_3_id' => $menu3Id
        ]);

        $this->flash('menu_add_success', 'منو با موفقیت به محصول اضافه شد');
        return redirect()->to('admin/product-menu3/manage/' . $productId);
    }
}