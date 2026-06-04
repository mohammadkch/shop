<?php

namespace App\Controllers\Admin;

class Menu2 extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $menu2Model = model('App\Models\Menu2Model');
        $menu1Model = model('App\Models\Menu1Model');

        // گرفتن page از POST (برای AJAX) یا GET (برای لود عادی)
        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $menu_1_id = $this->request->getPost('menu_1_id', FILTER_VALIDATE_INT);
        $name = $this->request->getPost('name', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $slug = $this->request->getPost('slug', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if ($menu_1_id !== '' && $menu_1_id !== null && $menu_1_id > 0) {
            $condition['menu_1_id'] = $menu_1_id;
        }
        if (!empty($name)) $condition['name'] = $name;
        if (!empty($slug)) $condition['slug'] = $slug;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $menu2Model->getData($condition, null, 0, true);
        $rowset = $menu2Model->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        // فقط در درخواست غیر AJAX فلش مسیج نشون بده
        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // دریافت لیست منوهای سطح 1 برای دراپ‌داون
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'همه منوهای سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        $this->viewData['search_fields'] = [
            'menu_1_id' => [
                'label' => 'منو سطح 1',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => $menu1_options
            ],
            'name' => [
                'label' => 'نام منو',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'نام منو'],
                'type' => 'text'
            ],
            'slug' => [
                'label' => 'slug',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'slug'],
                'type' => 'text'
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
        $this->viewData['edit_pk'] = 'id';
        $this->viewData['statusLabels'] = [1 => 'فعال', 0 => 'غیرفعال'];

        if ($this->request->isAJAX()) {
            return view('admin/menu2/index_data_table', $this->viewData);
        }

        return view('admin/menu2/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        // دریافت منوهای سطح 1 برای دراپ‌داون
        $menu1Model = model('App\Models\Menu1Model');
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'انتخاب منو سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        // دریافت انواع تصاویر (اگه وجود داشته باشه)
        $imageTypeModel = model('App\Models\Menu2ImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['inputs'] = [
            'menu_1_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_1_id', 'name' => 'menu_1_id'],
                'options' => $menu1_options
            ],
            'name' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'name', 'name' => 'name', 'placeholder' => 'نام منو'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
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

        // گرفتن لیبل فیلدها از دیتابیس
        $fieldModel = model('App\Models\FieldModel');
        $dbFields = $fieldModel->getFieldName(['menu_2']);

        $this->viewData['fields_name'] = mergeFieldsName($dbFields, $this->viewData['inputs']);
        $this->viewData['form_action'] = 'admin/menu2/create/handle';

        return view($this->viewPath . 'menu2/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $menu2Model = model('App\Models\Menu2Model');
        $menu2ImageModel = model('App\Models\Menu2ImageModel');

        $edit_row = $menu2Model->find($id);

        if ($edit_row == null) {
            $this->flash('menu_not_found');
            return redirect()->to('admin/menu2');
        }

        // دریافت تصاویر موجود این منو
        $existingImages = $menu2ImageModel
            ->select('menu_2_image.*, menu_2_image_type.name as type_name')
            ->join('menu_2_image_type', 'menu_2_image_type.id = menu_2_image.menu_2_image_type_id')
            ->where('menu_2_image.menu_2_id', $id)
            ->findAll();

        // گروه‌بندی تصاویر بر اساس type_id
        $groupedImages = [];
        foreach ($existingImages as $img) {
            $groupedImages[$img['menu_2_image_type_id']] = $img;
        }

        // دریافت انواع تصاویر
        $imageTypeModel = model('App\Models\Menu2ImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        // دریافت منوهای سطح 1 برای دراپ‌داون
        $menu1Model = model('App\Models\Menu1Model');
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'انتخاب منو سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['groupedImages'] = $groupedImages;
        $this->viewData['form_action'] = 'admin/menu2/edit/' . $id . '/handle';
        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['inputs'] = [
            'menu_1_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_1_id', 'name' => 'menu_1_id'],
                'options' => $menu1_options
            ],
            'name' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'name', 'name' => 'name', 'placeholder' => 'نام منو'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug (لینک دستی) - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
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
            'name' => 'نام منو',
            'slug' => 'slug',
            'is_active' => 'وضعیت'
        ];

        return view($this->viewPath . 'menu2/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/menu2');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $menu2Model = model('App\Models\Menu2Model');
        $menu2ImageModel = model('App\Models\Menu2ImageModel');
        $imageTypeModel = model('App\Models\Menu1ImageTypeModel');

        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $rules = [
            'menu_1_id' => [
                'label' => 'منو سطح 1',
                'rules' => 'required|is_natural_no_zero'
            ],
            'name' => [
                'label' => 'نام منو',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ]
        ];

        foreach ($imageTypes as $type) {
            $rules['image_' . $type['id']] = [
                'label' => $type['name'],
                'rules' => 'permit_empty|is_image[image_' . $type['id'] . ']|max_size[image_' . $type['id'] . ',' . ($type['file_size_limit'] ?: 2048) . ']|ext_in[image_' . $type['id'] . ',' . str_replace('|', ',', $type['extension']) . ']'
            ];
        }

        // متغیر برای ثبت وجود خطا در تصاویر
        $hasImageError = false;
        $imageErrors = [];

        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = $validation->getErrors();
            $this->flash('validation_error');

            if ($task == 'edit') {
                return $this->edit($id);
            } else {
                return $this->create();
            }
        }

        $slug = $this->request->getPost('slug', FILTER_SANITIZE_STRING);
        if (empty($slug)) {
            $slug = $this->slugify($this->request->getPost('name', FILTER_SANITIZE_STRING));
        }

        $model_data = [
            'menu_1_id' => (int) $this->request->getPost('menu_1_id', FILTER_VALIDATE_INT),
            'name' => $this->request->getPost('name', FILTER_SANITIZE_STRING),
            'slug' => $slug,
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'updated_at' => time()
        ];

        // ذخیره منو
        if ($task == 'create') {
            $model_data['created_at'] = time();
            $menuId = $menu2Model->insert($model_data);

            if (!$menuId) {
                $this->flash('menu_create_error');
                return redirect()->to('admin/menu2/create');
            }
        } else {
            $menuId = $id;
            $update_result = $menu2Model->update($menuId, $model_data);

            if (!$update_result) {
                $this->flash('menu_update_error');
                return redirect()->to('admin/menu2/edit/' . $menuId);
            }
        }

        if (!empty($imageTypes)) {
            foreach ($imageTypes as $type) {
                $file = $this->request->getFile('image_' . $type['id']);

                // اگه فایلی آپلود شده
                if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                    if (!$file->isValid()) {
                        $hasImageError = true;
                        $imageErrors[] = 'فایل آپلود شده معتبر نیست';
                        continue;
                    }

                    $allowedExtensions = explode('|', $type['extension']);
                    $fileExt = $file->getExtension();

                    if (!in_array($fileExt, $allowedExtensions)) {
                        $hasImageError = true;
                        $imageErrors[] = 'پسوند فایل باید ' . $type['extension'] . ' باشد';
                        continue;
                    }

                    if ($type['file_size_limit'] > 0 && $file->getSize() > ($type['file_size_limit'] * 1024)) {
                        $hasImageError = true;
                        $imageErrors[] = 'حجم فایل باید کمتر از ' . $type['file_size_limit'] . ' کیلوبایت باشد';
                        continue;
                    }

                    $uploadPath = FCPATH . $type['path'] . '/';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    // غیرفعال کردن تصاویر قبلی همون تایپ
                    $menu2ImageModel->where('menu_2_id', $menuId)
                        ->where('menu_2_image_type_id', $type['id'])
                        ->set(['is_active' => 0])
                        ->update();

                    $newName = time() . '_' . $file->getClientName();
                    $file->move($uploadPath, $newName);

                    $menu2ImageModel->insert([
                        'menu_2_image_type_id' => $type['id'],
                        'menu_2_id' => $menuId,
                        'image_name' => $newName,
                        'original_name' => $file->getClientName(),
                        'alt' => $this->request->getPost('alt_' . $type['id']),
                        'sort_order' => 0,
                        'is_active' => 1,
                        'created_at' => time(),
                        'updated_at' => time()
                    ]);
                }
            }
        }

        // اگر خطای تصویر داشتیم، به صفحه edit برگرد با پیام خطا
        if ($hasImageError) {
            $errorMessage = implode(' | ', $imageErrors);
            $this->flash('image_upload_error', $errorMessage);
            return redirect()->to('admin/menu2/edit/' . $menuId);
        }

        if ($task == 'create') {
            $this->flash('menu_create_success');
        } else {
            $this->flash('menu_update_success');
        }

        return redirect()->to('admin/menu2');
    }

    public function delete($id)
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menu2ImageModel = model('App\Models\Menu2ImageModel');
        $imageTypeModel = model('App\Models\Menu2ImageTypeModel');

        $menu = $menu2Model->find($id);

        if (!$menu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو یافت نشد'
            ]);
        }

        try {
            // حذف تصاویر فیزیکی با استفاده از مسیر دیتابیس
            $images = $menu2ImageModel->where('menu_2_id', $id)->findAll();

            foreach ($images as $image) {
                if (!empty($image['image_name'])) {
                    // گرفتن مسیر از جدول image_type
                    $type = $imageTypeModel->find($image['menu_2_image_type_id']);
                    if ($type && !empty($type['path'])) {
                        $uploadPath = FCPATH . $type['path'] . '/';
                        $filePath = $uploadPath . $image['image_name'];
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }
            }

            // حذف رکوردهای تصاویر
            $menu2ImageModel->where('menu_2_id', $id)->delete();

            if ($menu2Model->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'منو با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف منو'
                ]);
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'این منو دارای زیرمجموعه (منو سطح ۳ یا تصویر) می‌باشد. ابتدا زیرمجموعه‌های آن را حذف کنید.'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف: ' . $e->getMessage()
            ]);
        }
    }
    public function toggleActive($id)
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menu = $menu2Model->find($id);

        if (!$menu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو یافت نشد'
            ]);
        }

        $newStatus = $menu['is_active'] == 1 ? 0 : 1;

        if ($menu2Model->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'وضعیت منو با موفقیت تغییر کرد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در تغییر وضعیت'
            ]);
        }
    }

    private function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}