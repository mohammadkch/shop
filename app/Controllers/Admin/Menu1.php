<?php

namespace App\Controllers\Admin;

class Menu1 extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $menu1Model = model('App\Models\Menu1Model');

        // گرفتن page از POST (برای AJAX) یا GET (برای لود عادی)
        $page = (int) $this->request->getGet('page');
        $page = $page > 0 ? $page : 1;

        $name = $this->request->getPost('name', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $slug = $this->request->getPost('slug', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($name)) $condition['name'] = $name;
        if (!empty($slug)) $condition['slug'] = $slug;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $menu1Model->getData($condition, null, 0, true);
        $rowset = $menu1Model->getData($condition, $per_page, ($page - 1) * $per_page);

        // پردازش images_data هر رکورد
        foreach ($rowset as &$row) {
            $row['images'] = [];
            if (!empty($row['images_data'])) {
                $imagesParts = explode(';;;', $row['images_data']);
                foreach ($imagesParts as $part) {
                    $data = explode('|||', $part);
                    if (count($data) >= 8 && !empty($data[0])) {
                        $row['images'][] = [
                            'id' => $data[0],
                            'menu_1_image_type_id' => $data[1],
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

        // فقط در درخواست غیر AJAX فلش مسیج نشون بده
        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
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
            // برای دیباگ
            echo '<!-- AJAX request, page: ' . $page . ', total_rows: ' . $total_rows . ', rowset count: ' . count($rowset) . ' -->';
            return view('admin/menu1/index_data_table', $this->viewData);
        }

        return view('admin/menu1/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        // دریافت انواع تصاویر برای نمایش کادرهای آپلود
        $imageTypeModel = model('App\Models\Menu1ImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['inputs'] = [
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

        // گرفتن لیبل فیلدها از دیتابیس (کامنت فیلدها)
        $fieldModel = model('App\Models\FieldModel');
        $dbFields = $fieldModel->getFieldName(['menu_1']);

        // ترکیب لیبل‌های دیتابیس با لیبل‌های سفارشی (مثل slug که شاید کامنت نداشته باشه)
        $this->viewData['fields_name'] = mergeFieldsName($dbFields, $this->viewData['inputs']);

        $this->viewData['form_action'] = 'admin/menu1/create/handle';

        return view($this->viewPath.'menu1/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $menu1Model = model('App\Models\Menu1Model');
        $menu1ImageModel = model('App\Models\Menu1ImageModel');
        $imageTypeModel = model('App\Models\Menu1ImageTypeModel');

        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $edit_row = $menu1Model->find($id);

        if ($edit_row == null) {
            $this->flash('menu_not_found');
            return redirect()->to('admin/menu1');
        }

        $existingImages = $menu1ImageModel
            ->select('menu_1_image.*, menu_1_image_type.name as type_name')
            ->join('menu_1_image_type', 'menu_1_image_type.id = menu_1_image.menu_1_image_type_id')
            ->where('menu_1_image.menu_1_id', $id)
            ->orderBy('menu_1_image.is_active', 'DESC')  // اول تصاویر فعال
            ->orderBy('menu_1_image.created_at', 'DESC')
            ->findAll();

        // گروه‌بندی صحیح - همه تصاویر را نگه دار
        $groupedImages = [];
        foreach ($existingImages as $img) {
            $typeId = $img['menu_1_image_type_id'];
            if (!isset($groupedImages[$typeId])) {
                $groupedImages[$typeId] = [];
            }
            $groupedImages[$typeId][] = $img;  // آرایه‌ای از تصاویر
        }

        // فقط تصویر فعال را برای نمایش در پیش‌نمایش انتخاب کن
        $activeImages = [];
        foreach ($groupedImages as $typeId => $images) {
            foreach ($images as $img) {
                if ($img['is_active'] == 1) {
                    $activeImages[$typeId] = $img;
                    break;
                }
            }
            // اگر تصویر فعال نبود، اولین تصویر را بگیر
            if (!isset($activeImages[$typeId]) && !empty($images)) {
                $activeImages[$typeId] = $images[0];
            }
        }

        $this->viewData['groupedImages'] = $activeImages;  // فقط تصاویر فعال برای پیش‌نمایش
        $this->viewData['allImages'] = $groupedImages;     // همه تصاویر (اگر بعداً خواستید لیست بدهید)
        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['form_action'] = 'admin/menu1/edit/' . $id . '/handle';
        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['inputs'] = [
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
            'name' => 'نام منو',
            'slug' => 'slug',
            'is_active' => 'وضعیت'
        ];

        return view($this->viewPath.'menu1/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/menu1');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $menu1Model = model('App\Models\Menu1Model');
        $menu1ImageModel = model('App\Models\Menu1ImageModel');
        $imageTypeModel = model('App\Models\Menu1ImageTypeModel');

        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $rules = [
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
            'name' => $this->request->getPost('name', FILTER_SANITIZE_STRING),
            'slug' => $slug,
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'updated_at' => time()
        ];

        // ذخیره منو
        if ($task == 'create') {
            $model_data['created_at'] = time();
            $menuId = $menu1Model->insert($model_data);

            if (!$menuId) {
                $this->flash('menu_create_error');
                return redirect()->to('admin/menu1/create');
            }
        } else {
            $menuId = $id;
            $update_result = $menu1Model->update($menuId, $model_data);

            if (!$update_result) {
                $this->flash('menu_update_error');
                return redirect()->to('admin/menu1/edit/' . $menuId);
            }
        }

        foreach ($imageTypes as $type) {
            // دریافت alt از POST
            $newAlt = $this->request->getPost('alt_' . $type['id']);

            // پیدا کردن تصویر فعال فعلی برای این تایپ
            $existingImage = $menu1ImageModel
                ->where('menu_1_id', $menuId)
                ->where('menu_1_image_type_id', $type['id'])
                ->where('is_active', 1)
                ->first();

            // اگر تصویر فعال وجود دارد و alt تغییر کرده، آپدیت کن
            if ($existingImage) {
                // توجه: $newAlt می‌تواند رشته خالی هم باشد (مجاز است)
                if ($newAlt !== null && $newAlt != $existingImage['alt']) {
                    $updateAltResult = $menu1ImageModel->update($existingImage['id'], ['alt' => $newAlt]);
                    // دیباگ: لاگ کن ببینیم آپدیت شده یا نه
                    log_message('debug', 'Updating alt for type_id ' . $type['id'] . ': old="' . $existingImage['alt'] . '", new="' . $newAlt . '", result=' . ($updateAltResult ? 'success' : 'failed'));
                }
            } else {
                // اگر تصویر فعالی وجود ندارد، پیام لاگ بده
                log_message('debug', 'No active image found for menu_id ' . $menuId . ', type_id ' . $type['id']);
            }

            // پردازش آپلود فایل جدید
            $file = $this->request->getFile('image_' . $type['id']);
            // اگه فایلی آپلود شده
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                if (!$file->isValid()) {
                    $hasImageError = true;
                    $imageErrors[] = 'فایل آپلود شده معتبر نیست';
                    continue;
                }

                // بررسی نوع فایل با توجه به extension مجاز در type
                $allowedExtensions = explode('|', $type['extension']);
                $fileExt = $file->getExtension();

                if (!in_array($fileExt, $allowedExtensions)) {
                    $hasImageError = true;
                    $imageErrors[] = 'پسوند فایل باید ' . $type['extension'] . ' باشد';
                    continue;
                }

                // بررسی حجم فایل
                if ($type['file_size_limit'] > 0 && $file->getSize() > ($type['file_size_limit'] * 1024)) {
                    $hasImageError = true;
                    $imageErrors[] = 'حجم فایل باید کمتر از ' . $type['file_size_limit'] . ' کیلوبایت باشد';
                    continue;
                }

                // مسیر ذخیره (از دیتابیس بخون)
                $uploadPath = FCPATH . $type['path'] . '/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // غیرفعال کردن سایر تصاویر همون تایپ برای این منو
                $menu1ImageModel->where('menu_1_id', $menuId)
                    ->where('menu_1_image_type_id', $type['id'])
                    ->set(['is_active' => 0])
                    ->update();

                // ذخیره فایل جدید
                $newName = time() . '_' . $file->getClientName();
                $file->move($uploadPath, $newName);

                // ذخیره در دیتابیس
                $menu1ImageModel->insert([
                    'menu_1_image_type_id' => $type['id'],
                    'menu_1_id' => $menuId,
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

        // اگر خطای تصویر داشتیم، به صفحه edit برگرد با پیام خطا
        if ($hasImageError) {
            $errorMessage = implode(' | ', $imageErrors);
            $this->flash('image_upload_error', $errorMessage);
            return redirect()->to('admin/menu1/edit/' . $menuId);
        }

        if ($task == 'create') {
            $this->flash('menu_create_success');
        } else {
            $this->flash('menu_update_success');
        }

        return redirect()->to('admin/menu1');
    }

    public function delete($id)
    {
        $menu1Model = model('App\Models\Menu1Model');

        $menu = $menu1Model->find($id);

        if (!$menu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'منو یافت نشد'
            ]);
        }

        try {
            if ($menu1Model->delete($id)) {
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
            // بررسی خطای foreign key
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'این منو دارای زیرمجموعه (منو سطح ۲ یا تصویر) می‌باشد. ابتدا زیرمجموعه‌های آن را حذف کنید.'
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
        $menu1ImageModel = model('App\Models\Menu1ImageModel');
        $image = $menu1ImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // اگر میخواهیم غیرفعال کنیم
        if ($image['is_active'] == 1) {
            // چک کنیم آیا تصویر فعال دیگری برای این منو و این تایپ وجود دارد؟
            $activeCount = $menu1ImageModel
                ->where('menu_1_id', $image['menu_1_id'])
                ->where('menu_1_image_type_id', $image['menu_1_image_type_id'])
                ->where('is_active', 1)
                ->countAllResults();

            if ($activeCount <= 1) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'نمی‌توانید آخرین تصویر فعال این منو را غیرفعال کنید. ابتدا تصویر دیگری را فعال کنید.'
                ]);
            }
        }

        // غیرفعال کردن سایر تصاویر همون منو و همون تایپ
        $menu1ImageModel->where('menu_1_id', $image['menu_1_id'])
            ->where('menu_1_image_type_id', $image['menu_1_image_type_id'])
            ->set(['is_active' => 0])
            ->update();

        // فعال کردن تصویر انتخاب شده
        if ($menu1ImageModel->update($id, ['is_active' => 1])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت فعال شد'
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