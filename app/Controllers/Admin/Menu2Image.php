<?php

namespace App\Controllers\Admin;

class Menu2Image extends BaseController
{
    public function index()
    {
        helper('rowset');
        helper('sanitize');
        $pager = service('pager');
        $menu2ImageModel = model('App\Models\Menu2ImageModel');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $menu_2_id = $this->request->getPost('menu_2_id', FILTER_VALIDATE_INT);
        $menu_2_image_type_id = $this->request->getPost('menu_2_image_type_id', FILTER_VALIDATE_INT);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if ($menu_2_id !== '' && $menu_2_id !== null && $menu_2_id > 0) {
            $condition['menu_2_image.menu_2_id'] = $menu_2_id;
        }
        if ($menu_2_image_type_id !== '' && $menu_2_image_type_id !== null && $menu_2_image_type_id > 0) {
            $condition['menu_2_image.menu_2_image_type_id'] = $menu_2_image_type_id;
        }
        if ($is_active !== '' && $is_active !== null) {
            $condition['menu_2_image.is_active'] = $is_active;
        }

        $per_page = 10;
        $total_rows = $menu2ImageModel->getData($condition, null, 0, true);
        $rowset = $menu2ImageModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // دریافت لیست منوهای سطح 2 برای دراپ‌داون
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu2_options = ['' => 'همه منوها'] + \ROWSET::toKeyValue($menus2, 'id', 'name');

        // دریافت لیست انواع تصاویر
        $imageTypeModel = model('App\Models\Menu2ImageTypeModel');
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
            'menu_2_id' => [
                'label' => 'منو سطح 2',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => $menu2_options
            ],
            'menu_2_image_type_id' => [
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
            return view($this->viewPath . 'menu2_image/index_data_table', $this->viewData);
        }

        return view($this->viewPath . 'menu2_image/index', $this->viewData);
    }

    public function delete($id)
    {
        $menu2ImageModel = model('App\Models\Menu2ImageModel');
        $imageTypeModel = model('App\Models\Menu2ImageTypeModel');
        $image = $menu2ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        if ($image['is_active'] == 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر فعال قابل حذف نیست. ابتدا آن را غیرفعال کنید.'
            ]);
        }

        // حذف فایل فیزیکی با استفاده از مسیر دیتابیس
        if (!empty($image['image_name'])) {
            $type = $imageTypeModel->find($image['menu_2_image_type_id']);
            if ($type && !empty($type['path'])) {
                $uploadPath = FCPATH . $type['path'] . '/';
                $filePath = $uploadPath . $image['image_name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        if ($menu2ImageModel->delete($id)) {
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
        $menu2ImageModel = model('App\Models\Menu2ImageModel');
        $image = $menu2ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        $newStatus = $image['is_active'] == 1 ? 0 : 1;

        // اگر میخوای فعال کنی (از 0 به 1)
        if ($newStatus == 1) {
            // بقیه تصاویر همون تایپ رو غیرفعال کن
            $menu2ImageModel->where('menu_2_id', $image['menu_2_id'])
                ->where('menu_2_image_type_id', $image['menu_2_image_type_id'])
                ->set(['is_active' => 0])
                ->update();

            // این تصویر رو فعال کن
            $menu2ImageModel->update($id, ['is_active' => 1]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت فعال شد'
            ]);
        }
        // اگر میخوای غیرفعال کنی (از 1 به 0)
        else {
            // چک کن آیا تصویر فعال دیگری غیر از این وجود داره؟
            $activeCount = $menu2ImageModel
                ->where('menu_2_id', $image['menu_2_id'])
                ->where('menu_2_image_type_id', $image['menu_2_image_type_id'])
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
            $menu2ImageModel->update($id, ['is_active' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت غیرفعال شد'
            ]);
        }
    }
}