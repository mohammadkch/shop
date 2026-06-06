<?php

namespace App\Controllers\Admin;

class Menu3Image extends BaseController
{
    public function index()
    {
        helper('rowset');
        helper('sanitize');
        $pager = service('pager');
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $menu3Model = model('App\Models\Menu3Model');
        $menu2Model = model('App\Models\Menu2Model');
        $menu1Model = model('App\Models\Menu1Model');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        // فیلترها
        $menu_1_id = $this->request->getPost('menu_1_id', FILTER_VALIDATE_INT);
        $menu_2_id = $this->request->getPost('menu_2_id', FILTER_VALIDATE_INT);
        $menu_3_id = $this->request->getPost('menu_3_id', FILTER_VALIDATE_INT);
        $menu_3_image_type_id = $this->request->getPost('menu_3_image_type_id', FILTER_VALIDATE_INT);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];

        if ($menu_1_id !== '' && $menu_1_id !== null && $menu_1_id > 0) {
            $menu2Ids = $menu2Model->where('menu_1_id', $menu_1_id)->findColumn('id');
            if (!empty($menu2Ids)) {
                $menu3Ids = $menu3Model->whereIn('menu_2_id', $menu2Ids)->findColumn('id');
                if (!empty($menu3Ids)) {
                    $condition['menu_3_image.menu_3_id IN'] = '(' . implode(',', $menu3Ids) . ')';
                } else {
                    $condition['menu_3_image.id'] = 0; // بدون نتیجه
                }
            } else {
                $condition['menu_3_image.id'] = 0;
            }
        }

        if ($menu_2_id !== '' && $menu_2_id !== null && $menu_2_id > 0) {
            $menu3Ids = $menu3Model->where('menu_2_id', $menu_2_id)->findColumn('id');
            if (!empty($menu3Ids)) {
                $condition['menu_3_image.menu_3_id IN'] = '(' . implode(',', $menu3Ids) . ')';
            } else {
                $condition['menu_3_image.id'] = 0; // بدون نتیجه
            }
        }

        if ($menu_3_id !== '' && $menu_3_id !== null && $menu_3_id > 0) {
            $condition['menu_3_image.menu_3_id'] = $menu_3_id;
        }

        if ($menu_3_image_type_id !== '' && $menu_3_image_type_id !== null && $menu_3_image_type_id > 0) {
            $condition['menu_3_image.menu_3_image_type_id'] = $menu_3_image_type_id;
        }
        if ($is_active !== '' && $is_active !== null) {
            $condition['menu_3_image.is_active'] = $is_active;
        }

        $this->viewData['selected_menu_2_id'] = $menu_2_id;
        $this->viewData['selected_menu_3_id'] = $menu_3_id;

        $per_page = 10;
        $total_rows = $menu3ImageModel->getData($condition, null, 0, true);
        $rowset = $menu3ImageModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // لیست منوهای سطح 1 برای فیلتر
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'همه منوهای سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        // لیست منوهای سطح 2 برای فیلتر
        $menus2 = $menu2Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu2_options = ['' => 'همه منوهای سطح 2'] + \ROWSET::toKeyValue($menus2, 'id', 'name');

        // لیست منوهای سطح 3 برای فیلتر
        $menus3 = $menu3Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu3_options = ['' => 'همه منوهای سطح 3'] + \ROWSET::toKeyValue($menus3, 'id', 'name');

        // لیست انواع تصاویر
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();
        $type_options = ['' => 'همه انواع'] + \ROWSET::toKeyValue($imageTypes, 'id', 'name');

        foreach ($imageTypes as $type) {
            $label = $type['name'];
            if ($type['width'] && $type['height']) {
                $label .= ' (' . $type['width'] . 'x' . $type['height'] . ')';
            }
            $type_options[$type['id']] = $label;
        }

        $this->viewData['search_fields'] = [
            'menu_1_id' => [
                'label' => 'منو سطح 1',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'id' => 'filter_menu_1_id'],
                'options' => $menu1_options
            ],
            'menu_2_id' => [
                'label' => 'منو سطح 2',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'id' => 'filter_menu_2_id'],
                'options' => $menu2_options
            ],
            'menu_3_id' => [
                'label' => 'منو سطح 3',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'id' => 'filter_menu_3_id'],
                'options' => $menu3_options
            ],
            'menu_3_image_type_id' => [
                'label' => 'نوع تصویر',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => $type_options
            ],
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

        if ($this->request->isAJAX()) {
            return view($this->viewPath . 'menu3_image/index_data_table', $this->viewData);
        }

        return view($this->viewPath . 'menu3_image/index', $this->viewData);
    }

    public function delete($id)
    {
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');
        $image = $menu3ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // تصویر فعال قابل حذف نیست
        if ($image['is_active'] == 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر فعال قابل حذف نیست. ابتدا آن را غیرفعال کنید.'
            ]);
        }

        // حذف فایل فیزیکی
        if (!empty($image['image_name'])) {
            $type = $imageTypeModel->find($image['menu_3_image_type_id']);
            if ($type && !empty($type['path'])) {
                $uploadPath = FCPATH . $type['path'] . '/';
                $filePath = $uploadPath . $image['image_name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        if ($menu3ImageModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت حذف شد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف تصویر'
            ]);
        }
    }

    public function toggleActive($id)
    {
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $image = $menu3ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        $newStatus = $image['is_active'] == 1 ? 0 : 1;

        // اگر می‌خوای فعال کنی (از 0 به 1)
        if ($newStatus == 1) {
            // بقیه تصاویر همون منو با همون تایپ رو غیرفعال کن
            $menu3ImageModel->where('menu_3_id', $image['menu_3_id'])
                ->where('menu_3_image_type_id', $image['menu_3_image_type_id'])
                ->set(['is_active' => 0])
                ->update();

            // این تصویر رو فعال کن
            $menu3ImageModel->update($id, ['is_active' => 1]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت فعال شد'
            ]);
        }
        // اگر می‌خوای غیرفعال کنی (از 1 به 0)
        else {
            // چک کن آیا تصویر فعال دیگری غیر از این وجود داره؟
            $activeCount = $menu3ImageModel
                ->where('menu_3_id', $image['menu_3_id'])
                ->where('menu_3_image_type_id', $image['menu_3_image_type_id'])
                ->where('is_active', 1)
                ->where('id !=', $id)
                ->countAllResults();

            if ($activeCount == 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'حداقل یک تصویر باید فعال باشد. نمی‌توانید آخرین تصویر فعال را غیرفعال کنید.'
                ]);
            }

            // غیرفعال کن
            $menu3ImageModel->update($id, ['is_active' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت غیرفعال شد'
            ]);
        }
    }

    public function getAllMenu2()
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

        $options = [];
        foreach ($menus2 as $menu) {
            $options[] = [
                'id' => $menu['id'],
                'name' => $menu['name']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'options' => $options
        ]);
    }

    public function getMenu3ByMenu2($menu_2_id)
    {
        $menu3Model = model('App\Models\Menu3Model');
        $menus3 = $menu3Model->where('menu_2_id', $menu_2_id)
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $options = [];
        foreach ($menus3 as $menu) {
            $options[] = [
                'id' => $menu['id'],
                'name' => $menu['name']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'options' => $options
        ]);
    }

    public function getMenu2ByMenu1($menu_1_id)
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model->where('menu_1_id', $menu_1_id)
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $options = [];
        foreach ($menus2 as $menu) {
            $options[] = [
                'id' => $menu['id'],
                'name' => $menu['name']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'options' => $options
        ]);
    }
}