<?php

namespace App\Controllers\Admin;

class Menu1Image extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $menu1ImageModel = model('App\Models\Menu1ImageModel');

        // گرفتن page از GET یا POST
        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        // فیلترها
        $menu_1_id = $this->request->getPost('menu_1_id', FILTER_VALIDATE_INT);
        $menu_1_image_type_id = $this->request->getPost('menu_1_image_type_id', FILTER_VALIDATE_INT);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if ($menu_1_id !== '' && $menu_1_id !== null && $menu_1_id > 0) {
            $condition['menu_1_image.menu_1_id'] = $menu_1_id;
        }
        if ($menu_1_image_type_id !== '' && $menu_1_image_type_id !== null && $menu_1_image_type_id > 0) {
            $condition['menu_1_image.menu_1_image_type_id'] = $menu_1_image_type_id;
        }
        if ($is_active !== '' && $is_active !== null) {
            $condition['menu_1_image.is_active'] = $is_active;
        }

        $per_page = 10;
        $total_rows = $menu1ImageModel->getData($condition, null, 0, true);
        $rowset = $menu1ImageModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        // فقط در درخواست غیر AJAX فلش مسیج نشون بده
        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // دریافت لیست منوها برای دراپ‌داون
        $menu1Model = model('App\Models\Menu1Model');
        $menus = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu_options = ['' => 'همه منوها'] + \ROWSET::toKeyValue($menus, 'id', 'name');

        // دریافت لیست انواع تصاویر برای دراپ‌داون
        $imageTypeModel = model('App\Models\Menu1ImageTypeModel');
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
                'label' => 'منو',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => $menu_options
            ],
            'menu_1_image_type_id' => [
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
            return view($this->viewPath.'menu1_image/index_data_table', $this->viewData);
        }

        return view($this->viewPath.'menu1_image/index', $this->viewData);
    }

    public function delete($id)
    {
        $menu1ImageModel = model('App\Models\Menu1ImageModel');
        $image = $menu1ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // چک کردن فعال بودن تصویر - تصویر فعال قابل حذف نیست
        if ($image['is_active'] == 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر فعال قابل حذف نیست. ابتدا آن را غیرفعال کنید.'
            ]);
        }

        // حذف فایل فیزیکی (فقط برای تصاویر غیرفعال)
        if (!empty($image['image_name'])) {
            $uploadPath = FCPATH . 'images/menus/';
            $filePath = $uploadPath . $image['image_name'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // حذف رکورد از دیتابیس
        if ($menu1ImageModel->delete($id)) {
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
        $menu1ImageModel = model('App\Models\Menu1ImageModel');
        $image = $menu1ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        $newStatus = $image['is_active'] == 1 ? 0 : 1;

        // اگر میخوای غیرفعال کنی (از 1 به 0)
        if ($newStatus == 0) {
            // چک کن که آیا تصاویر فعال دیگری غیر از این وجود داره؟
            $activeCount = $menu1ImageModel
                ->where('menu_1_id', $image['menu_1_id'])
                ->where('menu_1_image_type_id', $image['menu_1_image_type_id'])
                ->where('is_active', 1)
                ->where('id !=', $id)
                ->countAllResults();

            // اگه هیچ تصویر فعال دیگه‌ای نیست، نذار غیرفعال کنه
            if ($activeCount == 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'نمی‌توانید آخرین تصویر فعال این منو را غیرفعال کنید.'
                ]);
            }

            // غیرفعال کن
            $menu1ImageModel->update($id, ['is_active' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت غیرفعال شد'
            ]);
        }
        // اگر میخوای فعال کنی (از 0 به 1)
        else {
            // اول بقیه تصاویر همون تایپ رو غیرفعال کن
            $menu1ImageModel->where('menu_1_id', $image['menu_1_id'])
                ->where('menu_1_image_type_id', $image['menu_1_image_type_id'])
                ->set(['is_active' => 0])
                ->update();

            // بعد این رو فعال کن
            $menu1ImageModel->update($id, ['is_active' => 1]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت فعال شد'
            ]);
        }
    }
}