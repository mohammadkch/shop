<?php

namespace App\Controllers\Admin;

class HomeSelectedCategory extends BaseController
{
    public function manage()
    {
        helper('sanitize');
        $pager = service('pager');
        $homeSelectedCategoryModel = model('App\Models\HomeSelectedCategoryModel');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $homeSelectedCategoryModel->getData($condition, null, 0, true);
        $rowset = $homeSelectedCategoryModel->getData($condition, $per_page, ($page - 1) * $per_page);

        // پردازش لایه هر رکورد
        foreach ($rowset as &$row) {
            if (!empty($row['menu_3_id'])) {
                $row['level'] = 3;
                $row['level_name'] = 'سطح 3';
            } elseif (!empty($row['menu_2_id'])) {
                $row['level'] = 2;
                $row['level_name'] = 'سطح 2';
            } elseif (!empty($row['menu_1_id'])) {
                $row['level'] = 1;
                $row['level_name'] = 'سطح 1';
            } else {
                $row['level'] = 0;
                $row['level_name'] = 'نامشخص';
            }
        }

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // دریافت منوهای سطح 1 برای فیلتر (فعلاً فیلتر نداریم، فقط برای نمایش)
        $menu1Model = model('App\Models\Menu1Model');
        $menu1List = $menu1Model->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        $this->viewData['search_fields'] = [
            'is_active' => [
                'label' => 'وضعیت',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => [
                    '' => 'همه',
                    '1' => 'فعال',
                    '0' => 'غیرفعال'
                ]
            ]
        ];

        $this->viewData['pagination'] = $pagination;
        $this->viewData['rowset'] = $rowset;
        $this->viewData['edit_pk'] = 'id';
        $this->viewData['statusLabels'] = [1 => 'فعال', 0 => 'غیرفعال'];

        if ($this->request->isAJAX()) {
            return view('admin/home_selected_category/manage_table', $this->viewData);
        }

        return view('admin/home_selected_category/manage', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler();
        }

        // دریافت منوهای سطح 1
        $menu1Model = model('App\Models\Menu1Model');
        $menu1List = $menu1Model->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        // منوهای سطح 2 (خالی برای شروع)
        $menu2List = [];

        // منوهای سطح 3 (خالی برای شروع)
        $menu3List = [];

        $this->viewData['menu1List'] = $menu1List;
        $this->viewData['menu2List'] = $menu2List;
        $this->viewData['menu3List'] = $menu3List;
        $this->viewData['inputs'] = [
            'menu_1_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_1_id', 'name' => 'menu_1_id'],
                'options' => ['' => 'انتخاب منو سطح 1'] + \ROWSET::toKeyValue($menu1List, 'id', 'name')
            ],
            'menu_2_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_2_id', 'name' => 'menu_2_id'],
                'options' => ['' => 'ابتدا منو سطح 1 را انتخاب کنید']
            ],
            'menu_3_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_3_id', 'name' => 'menu_3_id'],
                'options' => ['' => 'ابتدا منو سطح 2 را انتخاب کنید']
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'عدد بزرگتر = اولویت بیشتر', 'type' => 'number', 'min' => 0, 'value' => 0],
                'type' => 'number'
            ],
            'is_active' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'is_active', 'name' => 'is_active'],
                'options' => [
                    '1' => 'فعال',
                    '0' => 'غیرفعال'
                ]
            ]
        ];

        $this->viewData['fields_name'] = [
            'menu_1_id' => 'منو سطح 1',
            'menu_2_id' => 'منو سطح 2',
            'menu_3_id' => 'منو سطح 3',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/home-selected-category/create/handle';

        return view('admin/home_selected_category/create', $this->viewData);
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

    public function formHandler()
    {
        helper('sanitize');
        $validation = \Config\Services::validation();
        $homeSelectedCategoryModel = model('App\Models\HomeSelectedCategoryModel');

        $rules = [
            'sort_order' => [
                'label' => 'ترتیب',
                'rules' => 'permit_empty|integer|greater_than_equal_to[0]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ]
        ];

        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = $validation->getErrors();
            $this->flash('validation_error');
            return $this->create();
        }

        // دریافت مقادیر از POST
        $menu1Id = (int) $this->request->getPost('menu_1_id');
        $menu2Id = (int) $this->request->getPost('menu_2_id');
        $menu3Id = (int) $this->request->getPost('menu_3_id');

        // تشخیص آخرین لایه انتخاب شده
        $modelData = [];
        if ($menu3Id > 0) {
            // سطح 3 انتخاب شده
            $modelData['menu_3_id'] = $menu3Id;
            $modelData['menu_2_id'] = null;
            $modelData['menu_1_id'] = null;
            $checkField = 'menu_3_id';
            $checkValue = $menu3Id;
        } elseif ($menu2Id > 0) {
            // سطح 2 انتخاب شده
            $modelData['menu_2_id'] = $menu2Id;
            $modelData['menu_1_id'] = null;
            $modelData['menu_3_id'] = null;
            $checkField = 'menu_2_id';
            $checkValue = $menu2Id;
        } elseif ($menu1Id > 0) {
            // سطح 1 انتخاب شده
            $modelData['menu_1_id'] = $menu1Id;
            $modelData['menu_2_id'] = null;
            $modelData['menu_3_id'] = null;
            $checkField = 'menu_1_id';
            $checkValue = $menu1Id;
        } else {
            $this->flash('validation_error', 'لطفاً حداقل یک منو انتخاب کنید');
            return redirect()->to('admin/home-selected-category/create');
        }

        // بررسی تکراری نبودن
        $exists = $homeSelectedCategoryModel
            ->where($checkField, $checkValue)
            ->first();

        if ($exists) {
            $this->flash('validation_error', 'این منو قبلاً به لیست منتخب اضافه شده است');
            return redirect()->to('admin/home-selected-category/create');
        }

        // دیتای نهایی
        $modelData['sort_order'] = (int) ($this->request->getPost('sort_order') ?: 0);
        $modelData['is_active'] = (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT);
        $modelData['created_at'] = time();
        $modelData['updated_at'] = time();

        $result = $homeSelectedCategoryModel->insert($modelData);

        if (!$result) {
            $this->flash('category_create_error');
            return redirect()->to('admin/home-selected-category/create');
        }

        $this->flash('category_create_success');
        return redirect()->to('admin/home-selected-category/manage');
    }

    public function delete($id)
    {
        $homeSelectedCategoryModel = model('App\Models\HomeSelectedCategoryModel');
        $record = $homeSelectedCategoryModel->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رکورد یافت نشد'
            ]);
        }

        if ($record['is_active'] == 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'نمی‌توانید رکورد فعال را حذف کنید. ابتدا آن را غیرفعال کنید.'
            ]);
        }

        if ($homeSelectedCategoryModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'منو با موفقیت از لیست منتخب حذف شد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف'
            ]);
        }
    }

    public function toggleActive($id)
    {
        $homeSelectedCategoryModel = model('App\Models\HomeSelectedCategoryModel');
        $record = $homeSelectedCategoryModel->find($id);

        if (!$record) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'رکورد یافت نشد'
            ]);
        }

        $newStatus = $record['is_active'] == 1 ? 0 : 1;

        if ($homeSelectedCategoryModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'وضعیت با موفقیت تغییر کرد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در تغییر وضعیت'
            ]);
        }
    }
}