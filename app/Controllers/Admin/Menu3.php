<?php

namespace App\Controllers\Admin;

class Menu3 extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $menu3Model = model('App\Models\Menu3Model');
        $menu2Model = model('App\Models\Menu2Model');
        $menu1Model = model('App\Models\Menu1Model');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $menu_1_id = $this->request->getPost('menu_1_id', FILTER_VALIDATE_INT);
        $menu_2_id = $this->request->getPost('menu_2_id', FILTER_VALIDATE_INT);
        $name = $this->request->getPost('name', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $slug = $this->request->getPost('slug', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];

        if ($menu_1_id !== '' && $menu_1_id !== null && $menu_1_id > 0) {
            $menu2Ids = $menu2Model->where('menu_1_id', $menu_1_id)->findColumn('id');
            if (!empty($menu2Ids)) {
                $menu3Ids = $menu3Model->whereIn('menu_2_id', $menu2Ids)->findColumn('id');
                if (!empty($menu3Ids)) {
                    $condition['menu_3.id IN'] = '(' . implode(',', $menu3Ids) . ')';
                } else {
                    $condition['menu_3.id'] = 0;
                }
            } else {
                $condition['menu_3.id'] = 0;
            }
        }

        if ($menu_2_id !== '' && $menu_2_id !== null && $menu_2_id > 0) {
            $menu3Ids = $menu3Model->where('menu_2_id', $menu_2_id)->findColumn('id');
            if (!empty($menu3Ids)) {
                $condition['menu_3.id IN'] = '(' . implode(',', $menu3Ids) . ')';
                unset($condition['menu_3.id']);
            } else {
                $condition['menu_3.id'] = 0;
                unset($condition['menu_3.id IN']);
            }
        }

        if (!empty($name)) $condition['name'] = $name;
        if (!empty($slug)) $condition['slug'] = $slug;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $menu3Model->getData($condition, null, 0, true);
        $rowset = $menu3Model->getData($condition, $per_page, ($page - 1) * $per_page);

        foreach ($rowset as &$row) {
            $row['images'] = [];
            if (!empty($row['images_data'])) {
                $imagesParts = explode(';;;', $row['images_data']);
                foreach ($imagesParts as $part) {
                    $data = explode('|||', $part);
                    if (count($data) >= 8 && !empty($data[0])) {
                        $row['images'][] = [
                            'id' => $data[0],
                            'menu_3_image_type_id' => $data[1],
                            'image_name' => $data[2],
                            'original_name' => $data[3],
                            'alt' => $data[4],
                            'sort_order' => $data[5],
                            'type_name' => $data[6],
                            'path' => $data[7],
                        ];
                    }
                }
            }
            unset($row['images_data']);
        }

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        // لیست منوهای سطح 1 برای دراپ‌داون (فقط برای فیلتر کردن منوی سطح 2)
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'همه منوهای سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        // لیست منوهای سطح 2 برای فیلتر اصلی
        $menus2 = $menu2Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu2_options = ['' => 'همه منوهای سطح 2'] + \ROWSET::toKeyValue($menus2, 'id', 'name');

        $this->viewData['search_fields'] = [
            'menu_1_id' => [
                'label' => 'منو سطح 1',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'id' => 'filter_menu_1_id'],  // <-- id اینجا اضافه شد
                'options' => $menu1_options
            ],
            'menu_2_id' => [
                'label' => 'منو سطح 2',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'id' => 'filter_menu_2_id'],  // <-- id اینجا اضافه شد
                'options' => $menu2_options
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
            return view('admin/menu3/index_data_table', $this->viewData);
        }

        return view('admin/menu3/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        // دریافت منوهای سطح 1 برای دراپ‌داون اول
        $menu1Model = model('App\Models\Menu1Model');
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'ابتدا منو سطح 1 را انتخاب کنید'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        // منوهای سطح 2 (خالی برای شروع)
        $menu2_options = ['' => 'ابتدا منو سطح 1 را انتخاب کنید'];

        // دریافت انواع تصاویر
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['menu1_options'] = $menu1_options;
        $this->viewData['menu2_options'] = $menu2_options;
        $this->viewData['inputs'] = [
            'menu_1_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_1_id', 'name' => 'menu_1_id'],
                'options' => $menu1_options
            ],
            'menu_2_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_2_id', 'name' => 'menu_2_id'],
                'options' => $menu2_options
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
            // ======== اضافه شد ========
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات منو (اختیاری)', 'rows' => 4],
                'type' => 'textarea'
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'عدد بزرگتر = اولویت بیشتر', 'type' => 'number', 'min' => 0],
                'type' => 'number'
            ],
            // ======== پایان اضافه شد ========
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
            'name' => 'نام منو',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/menu3/create/handle';

        return view($this->viewPath . 'menu3/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $menu3Model = model('App\Models\Menu3Model');
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $menu1Model = model('App\Models\Menu1Model');
        $menu2Model = model('App\Models\Menu2Model');
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');

        $edit_row = $menu3Model->find($id);

        if ($edit_row == null) {
            $this->flash('menu_not_found');
            return redirect()->to('admin/menu3');
        }

        // دریافت منوی سطح 2 فعلی برای تعیین menu_1_id پیش‌فرض
        $currentMenu2 = $menu2Model->find($edit_row['menu_2_id']);
        $default_menu_1_id = $currentMenu2 ? $currentMenu2['menu_1_id'] : 0;

        // دریافت منوهای سطح 1
        $menus1 = $menu1Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu1_options = ['' => 'انتخاب منو سطح 1'] + \ROWSET::toKeyValue($menus1, 'id', 'name');

        // دریافت منوهای سطح 2 مرتبط با منوی سطح 1 انتخاب شده
        $menus2 = $menu2Model->where('menu_1_id', $default_menu_1_id)->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
        $menu2_options = ['' => 'انتخاب منو سطح 2'] + \ROWSET::toKeyValue($menus2, 'id', 'name');

        // دریافت تصاویر موجود این منو
        $existingImages = $menu3ImageModel
            ->select('menu_3_image.*, menu_3_image_type.name as type_name')
            ->join('menu_3_image_type', 'menu_3_image_type.id = menu_3_image.menu_3_image_type_id')
            ->where('menu_3_image.menu_3_id', $id)
            ->findAll();

        // گروه‌بندی تصاویر بر اساس type_id
        $groupedImages = [];
        foreach ($existingImages as $img) {
            if (!isset($groupedImages[$img['menu_3_image_type_id']])) {
                $groupedImages[$img['menu_3_image_type_id']] = [];
            }
            $groupedImages[$img['menu_3_image_type_id']][] = $img;
        }

        // دریافت انواع تصاویر
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['groupedImages'] = $groupedImages;
        $this->viewData['menu1_options'] = $menu1_options;
        $this->viewData['menu2_options'] = $menu2_options;
        $this->viewData['default_menu_1_id'] = $default_menu_1_id;
        $this->viewData['form_action'] = 'admin/menu3/edit/' . $id . '/handle';
        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['inputs'] = [
            'menu_1_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_1_id', 'name' => 'menu_1_id'],
                'options' => $menu1_options
            ],
            'menu_2_id' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'menu_2_id', 'name' => 'menu_2_id'],
                'options' => $menu2_options
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
            // ======== اضافه شد ========
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات منو (اختیاری)', 'rows' => 4],
                'type' => 'textarea'
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'عدد بزرگتر = اولویت بیشتر', 'type' => 'number', 'min' => 0],
                'type' => 'number'
            ],
            // ======== پایان اضافه شد ========
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
            'name' => 'نام منو',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        return view($this->viewPath . 'menu3/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/menu3');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $menu3Model = model('App\Models\Menu3Model');
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');
        $menu2Model = model('App\Models\Menu2Model');

        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $rules = [
            'menu_2_id' => [
                'label' => 'منو سطح 2',
                'rules' => 'required|is_natural_no_zero'
            ],
            'name' => [
                'label' => 'نام منو',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ],
            // ======== اضافه شد ========
            'description' => [
                'label' => 'توضیحات',
                'rules' => 'permit_empty|max_length[65535]'
            ],
            'sort_order' => [
                'label' => 'ترتیب',
                'rules' => 'permit_empty|integer|greater_than_equal_to[0]'
            ]
            // ======== پایان اضافه شد ========
        ];

        foreach ($imageTypes as $type) {
            $rules['image_' . $type['id']] = [
                'label' => $type['name'],
                'rules' => 'permit_empty|is_image[image_' . $type['id'] . ']|max_size[image_' . $type['id'] . ',' . ($type['file_size_limit'] ?: 2048) . ']|ext_in[image_' . $type['id'] . ',' . str_replace('|', ',', $type['extension']) . ']'
            ];
        }

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

        $slugCheck = $menu3Model->where('slug', $slug);
        if ($task == 'edit') {
            $slugCheck->where('id !=', $id);
        }
        if ($slugCheck->first()) {
            $this->flash('validation_error', 'این slug قبلاً استفاده شده است.');
            if ($task == 'edit') {
                return $this->edit($id);
            } else {
                return $this->create();
            }
        }

        $menu2 = $menu2Model->find((int)$this->request->getPost('menu_2_id', FILTER_VALIDATE_INT));
        if (!$menu2) {
            $this->flash('validation_error', 'منو سطح 2 انتخاب شده معتبر نیست.');
            if ($task == 'edit') {
                return $this->edit($id);
            } else {
                return $this->create();
            }
        }

        $model_data = [
            'menu_2_id' => (int) $this->request->getPost('menu_2_id', FILTER_VALIDATE_INT),
            'name' => $this->request->getPost('name', FILTER_SANITIZE_STRING),
            'slug' => $slug,
            'description' => $this->request->getPost('description', FILTER_SANITIZE_STRING),
            'sort_order' => (int) ($this->request->getPost('sort_order', FILTER_VALIDATE_INT) ?: 0),
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'updated_at' => time()
        ];

        if ($task == 'create') {
            $model_data['created_at'] = time();
            $menuId = $menu3Model->insert($model_data);

            if (!$menuId) {
                $this->flash('menu_create_error');
                return redirect()->to('admin/menu3/create');
            }
        } else {
            $menuId = $id;
            $update_result = $menu3Model->update($menuId, $model_data);

            if (!$update_result) {
                $this->flash('menu_update_error');
                return redirect()->to('admin/menu3/edit/' . $menuId);
            }
        }


        if (!empty($imageTypes)) {
            foreach ($imageTypes as $type) {
                // ======== اصلاح 1: فقط تصویر فعال را آپدیت کن ========
                $existingImage = $menu3ImageModel
                    ->where('menu_3_id', $menuId)
                    ->where('menu_3_image_type_id', $type['id'])
                    ->where('is_active', 1)
                    ->first();

                if ($existingImage) {
                    $newAlt = $this->request->getPost('alt_' . $type['id']);
                    if ($newAlt !== null && $newAlt != $existingImage['alt']) {
                        $menu3ImageModel->update($existingImage['id'], ['alt' => $newAlt]);
                    }
                }

                // ======== اصلاح 2: از getFile استفاده کن نه getFileMultiple ========
                $file = $this->request->getFile('image_' . $type['id']);

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

                    // ======== اصلاح 3: غیرفعال کردن تصاویر قبلی همون تایپ ========
                    $menu3ImageModel->where('menu_3_id', $menuId)
                        ->where('menu_3_image_type_id', $type['id'])
                        ->set(['is_active' => 0])
                        ->update();

                    $newName = time() . '_' . $file->getClientName();
                    $file->move($uploadPath, $newName);

                    $menu3ImageModel->insert([
                        'menu_3_image_type_id' => $type['id'],
                        'menu_3_id' => $menuId,
                        'image_name' => $newName,
                        'original_name' => $file->getClientName(),
                        'alt' => $this->request->getPost('alt_' . $type['id']),
                        'sort_order' => 0,
                        'is_active' => 1,  // ======== فعال باشد ========
                        'created_at' => time(),
                        'updated_at' => time()
                    ]);
                }
            }
        }

        if ($hasImageError) {
            $errorMessage = implode(' | ', $imageErrors);
            $this->flash('image_upload_error', $errorMessage);
            return redirect()->to('admin/menu3/edit/' . $menuId);
        }

        if ($task == 'create') {
            $this->flash('menu_create_success');
        } else {
            $this->flash('menu_update_success');
        }

        return redirect()->to('admin/menu3');
    }

    public function delete($id)
    {
        $menu3Model = model('App\Models\Menu3Model');
        $menu3ImageModel = model('App\Models\Menu3ImageModel');
        $imageTypeModel = model('App\Models\Menu3ImageTypeModel');

        $menu = $menu3Model->find($id);

        if (!$menu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو یافت نشد'
            ]);
        }

        try {
            // حذف تصاویر فیزیکی
            $images = $menu3ImageModel->where('menu_3_id', $id)->findAll();

            foreach ($images as $image) {
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
            }

            // حذف رکوردهای تصاویر
            $menu3ImageModel->where('menu_3_id', $id)->delete();

            if ($menu3Model->delete($id)) {
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
                    'message' => 'این منو دارای محصول می‌باشد. ابتدا محصولات آن را حذف کنید.'
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
        $menu3Model = model('App\Models\Menu3Model');
        $menu = $menu3Model->find($id);

        if (!$menu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو یافت نشد'
            ]);
        }

        $newStatus = $menu['is_active'] == 1 ? 0 : 1;

        if ($menu3Model->update($id, ['is_active' => $newStatus])) {
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

    public function getMenu2ByMenu1($menu_1_id)
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model->where('menu_1_id', $menu_1_id)
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $options = [['id' => '', 'name' => 'همه منوهای سطح 2']];
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

    public function getAllMenu2()
    {
        $menu2Model = model('App\Models\Menu2Model');
        $menus2 = $menu2Model->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

        $options = [['id' => '', 'name' => 'همه منوهای سطح 2']];
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