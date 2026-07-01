<?php

namespace App\Controllers\Admin;

class Product extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $productModel = model('App\Models\ProductModel');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $name = $this->request->getPost('name', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $slug = $this->request->getPost('slug', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($name)) $condition['name'] = $name;
        if (!empty($slug)) $condition['slug'] = $slug;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $productModel->getData($condition, null, 0, true);
        $rowset = $productModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
            'name' => [
                'label' => 'نام محصول',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'نام محصول'],
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
            return view('admin/product/index_data_table', $this->viewData);
        }

        return view('admin/product/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        $this->viewData['inputs'] = [
            'name' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'name', 'name' => 'name', 'placeholder' => 'نام محصول'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات محصول', 'rows' => 6],
                'type' => 'textarea'
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
            'name' => 'نام محصول',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/product/create/handle';

        return view('admin/product/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $productModel = model('App\Models\ProductModel');
        $edit_row = $productModel->find($id);

        if ($edit_row == null) {
            $this->flash('product_not_found');
            return redirect()->to('admin/product');
        }

        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['form_action'] = 'admin/product/edit/' . $id . '/handle';
        $this->viewData['inputs'] = [
            'name' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'name', 'name' => 'name', 'placeholder' => 'نام محصول'],
                'type' => 'text'
            ],
            'slug' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'slug', 'name' => 'slug', 'placeholder' => 'slug - خالی بگذارید خودکار می‌شود'],
                'type' => 'text'
            ],
            'description' => [
                'input' => 'form_textarea',
                'data' => ['class' => 'form-control', 'id' => 'description', 'name' => 'description', 'placeholder' => 'توضیحات محصول', 'rows' => 6],
                'type' => 'textarea'
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
            'name' => 'نام محصول',
            'slug' => 'slug',
            'description' => 'توضیحات',
            'is_active' => 'وضعیت'
        ];

        return view('admin/product/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/product');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $productModel = model('App\Models\ProductModel');

        $rules = [
            'name' => [
                'label' => 'نام محصول',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ]
        ];

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
            'description' => $this->request->getPost('description', FILTER_SANITIZE_STRING),
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'published_at' => time(),
            'updated_at' => time()
        ];

        if ($task == 'create') {
            $model_data['created_at'] = time();
            $productId = $productModel->insert($model_data);

            if (!$productId) {
                $this->flash('product_create_error');
                return redirect()->to('admin/product/create');
            }
        } else {
            $productId = $id;
            $update_result = $productModel->update($productId, $model_data);

            if (!$update_result) {
                $this->flash('product_update_error');
                return redirect()->to('admin/product/edit/' . $productId);
            }
        }

        if ($task == 'create') {
            $this->flash('product_create_success');
        } else {
            $this->flash('product_update_success');
        }

        return redirect()->to('admin/product');
    }

    public function delete($id)
    {
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'محصول یافت نشد'
            ]);
        }

        try {
            if ($productModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'محصول با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف محصول'
                ]);
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'این محصول دارای وابستگی است. ابتدا وابستگی‌های آن را حذف کنید.'
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
        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'محصول یافت نشد'
            ]);
        }

        $newStatus = $product['is_active'] == 1 ? 0 : 1;

        if ($productModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'وضعیت محصول با موفقیت تغییر کرد'
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