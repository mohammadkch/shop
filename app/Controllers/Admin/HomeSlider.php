<?php

namespace App\Controllers\Admin;

class HomeSlider extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $homeSliderModel = model('App\Models\HomeSliderModel');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $title = $this->request->getPost('title', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($title)) $condition['title'] = $title;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $homeSliderModel->getData($condition, null, 0, true);
        $rowset = $homeSliderModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
            'title' => [
                'label' => 'عنوان اسلایدر',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'عنوان اسلایدر'],
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
            return view('admin/home_slider/index_data_table', $this->viewData);
        }

        return view('admin/home_slider/index', $this->viewData);
    }

    public function create($task = null)
    {
        helper('fields');

        if ($task == 'handle') {
            return $this->formHandler('create', 0);
        }

        $this->viewData['inputs'] = [
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان اسلایدر'],
                'type' => 'text'
            ],
            'image' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'image', 'name' => 'image', 'type' => 'file', 'accept' => 'image/*'],
                'type' => 'file'
            ],
            'link' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'link', 'name' => 'link', 'placeholder' => 'لینک (مثال: # یا https://example.com)'],
                'type' => 'text'
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
            'title' => 'عنوان',
            'image' => 'تصویر اسلایدر',
            'link' => 'لینک',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/home-slider/create/handle';

        return view('admin/home_slider/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $homeSliderModel = model('App\Models\HomeSliderModel');
        $edit_row = $homeSliderModel->find($id);

        if ($edit_row == null) {
            $this->flash('slider_not_found');
            return redirect()->to('admin/home-slider');
        }

        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['form_action'] = 'admin/home-slider/edit/' . $id . '/handle';
        $this->viewData['inputs'] = [
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان اسلایدر'],
                'type' => 'text'
            ],
            'image' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'image', 'name' => 'image', 'type' => 'file', 'accept' => 'image/*'],
                'type' => 'file'
            ],
            'link' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'link', 'name' => 'link', 'placeholder' => 'لینک (مثال: # یا https://example.com)'],
                'type' => 'text'
            ],
            'sort_order' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'sort_order', 'name' => 'sort_order', 'placeholder' => 'عدد بزرگتر = اولویت بیشتر', 'type' => 'number', 'min' => 0],
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
            'title' => 'عنوان',
            'image' => 'تصویر اسلایدر',
            'link' => 'لینک',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        return view('admin/home_slider/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/home-slider');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $homeSliderModel = model('App\Models\HomeSliderModel');

        $rules = [
            'title' => [
                'label' => 'عنوان',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'link' => [
                'label' => 'لینک',
                'rules' => 'required|max_length[255]'
            ],
            'sort_order' => [
                'label' => 'ترتیب',
                'rules' => 'permit_empty|integer|greater_than_equal_to[0]'
            ],
            'is_active' => [
                'label' => 'وضعیت',
                'rules' => 'required|in_list[0,1]'
            ]
        ];

        // قوانین فایل (اجباری برای create، اختیاری برای edit)
        if ($task == 'create') {
            $rules['image'] = [
                'label' => 'تصویر اسلایدر',
                'rules' => 'uploaded[image]|is_image[image]|max_size[image,300]|ext_in[image,jpg,jpeg,png,gif,webp]'
            ];
        } else {
            $rules['image'] = [
                'label' => 'تصویر اسلایدر',
                'rules' => 'permit_empty|is_image[image]|max_size[image,300]|ext_in[image,jpg,jpeg,png,gif,webp]'
            ];
        }

        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = $validation->getErrors();
            $this->flash('validation_error');

            if ($task == 'edit') {
                return $this->edit($id);
            } else {
                return $this->create();
            }
        }

        // دیتای پایه
        $model_data = [
            'title' => $this->request->getPost('title', FILTER_SANITIZE_STRING),
            'link' => $this->request->getPost('link', FILTER_SANITIZE_STRING),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'updated_at' => time()
        ];

        // پردازش آپلود فایل
        $uploadPath = FCPATH . 'images/home/sliders/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($imageFile->isValid()) {
                $imageName = time() . '_' . $imageFile->getClientName();
                $imageFile->move($uploadPath, $imageName);
                $model_data['image'] = 'home/sliders/' . $imageName;
            }
        } elseif ($task == 'edit') {
            // در ویرایش، اگر فایل جدید نیومد، مقدار قبلی رو نگه دار
            $edit_row = $homeSliderModel->find($id);
            if ($edit_row && !empty($edit_row['image'])) {
                $model_data['image'] = $edit_row['image'];
            }
        }

        // ذخیره
        if ($task == 'create') {
            $model_data['created_at'] = time();
            $sliderId = $homeSliderModel->insert($model_data);

            if (!$sliderId) {
                $this->flash('slider_create_error');
                return redirect()->to('admin/home-slider/create');
            }
        } else {
            $sliderId = $id;
            $update_result = $homeSliderModel->update($sliderId, $model_data);

            if (!$update_result) {
                $this->flash('slider_update_error');
                return redirect()->to('admin/home-slider/edit/' . $sliderId);
            }
        }

        if ($task == 'create') {
            $this->flash('slider_create_success');
        } else {
            $this->flash('slider_update_success');
        }

        return redirect()->to('admin/home-slider');
    }

    public function delete($id)
    {
        $homeSliderModel = model('App\Models\HomeSliderModel');
        $slider = $homeSliderModel->find($id);

        if (!$slider) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'اسلایدر یافت نشد'
            ]);
        }

        try {
            // حذف فایل فیزیکی
            if (!empty($slider['image'])) {
                $uploadPath = FCPATH . 'images/home/sliders/';
                $filePath = $uploadPath . basename($slider['image']);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($homeSliderModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'اسلایدر با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف اسلایدر'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در حذف: ' . $e->getMessage()
            ]);
        }
    }

    public function toggleActive($id)
    {
        $homeSliderModel = model('App\Models\HomeSliderModel');
        $slider = $homeSliderModel->find($id);

        if (!$slider) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'اسلایدر یافت نشد'
            ]);
        }

        $newStatus = $slider['is_active'] == 1 ? 0 : 1;

        if ($homeSliderModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'وضعیت اسلایدر با موفقیت تغییر کرد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در تغییر وضعیت'
            ]);
        }
    }
}