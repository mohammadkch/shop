<?php

namespace App\Controllers\Admin;

class HomeStory extends BaseController
{
    public function index()
    {
        helper('sanitize');
        $pager = service('pager');
        $homeStoryModel = model('App\Models\HomeStoryModel');

        $page = (int) ($this->request->getPost('page') ?? $this->request->getGet('page'));
        $page = $page > 0 ? $page : 1;

        $title = $this->request->getPost('title', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $type = $this->request->getPost('type', FILTER_SANITIZE_STRING);
        $is_active = $this->request->getPost('is_active', FILTER_VALIDATE_INT);

        $condition = [];
        if (!empty($title)) $condition['title'] = $title;
        if (!empty($type)) $condition['type'] = $type;
        if ($is_active !== '' && $is_active !== null) $condition['is_active'] = $is_active;

        $per_page = 10;
        $total_rows = $homeStoryModel->getData($condition, null, 0, true);
        $rowset = $homeStoryModel->getData($condition, $per_page, ($page - 1) * $per_page);

        $pagination = $pager->makeLinks($page, $per_page, $total_rows, 'admin_pagination');

        if ($total_rows == 0 && !empty($condition) && !$this->request->isAJAX()) {
            $this->flash('no_result');
        }

        $this->viewData['search_fields'] = [
            'title' => [
                'label' => 'عنوان استوری',
                'input' => 'form_input',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white', 'placeholder' => 'عنوان استوری'],
                'type' => 'text'
            ],
            'type' => [
                'label' => 'نوع',
                'input' => 'form_dropdown',
                'data' => ['class' => 'search-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-400 focus:border-primary-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white'],
                'options' => [
                    '' => 'همه',
                    'image' => 'تصویر',
                    'video' => 'ویدئو'
                ]
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
            return view('admin/home_story/index_data_table', $this->viewData);
        }

        return view('admin/home_story/index', $this->viewData);
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
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان استوری'],
                'type' => 'text'
            ],
            'type' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'type', 'name' => 'type'],
                'options' => [
                    'image' => 'تصویر',
                    'video' => 'ویدئو'
                ]
            ],
            'avatar' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'avatar', 'name' => 'avatar', 'type' => 'file', 'accept' => 'image/*'],
                'type' => 'file'
            ],
            'url' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'url', 'name' => 'url', 'type' => 'file', 'accept' => 'image/*,video/*'],
                'type' => 'file'
            ],
            'duration' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'duration', 'name' => 'duration', 'placeholder' => 'مدت زمان (میلی‌ثانیه) - فقط برای تصویر', 'type' => 'number', 'min' => 0],
                'type' => 'number'
            ],
            'link' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'link', 'name' => 'link', 'placeholder' => 'لینک (اختیاری)'],
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
            'type' => 'نوع',
            'avatar' => 'تصویر آواتار',
            'url' => 'فایل اصلی',
            'duration' => 'مدت زمان (میلی‌ثانیه)',
            'link' => 'لینک',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        $this->viewData['form_action'] = 'admin/home-story/create/handle';

        return view('admin/home_story/create', $this->viewData);
    }

    public function edit($id, $task = null)
    {
        $id = (int) $id;

        if ($task == 'handle') {
            return $this->formHandler('edit', $id);
        }

        $homeStoryModel = model('App\Models\HomeStoryModel');
        $edit_row = $homeStoryModel->find($id);

        if ($edit_row == null) {
            $this->flash('story_not_found');
            return redirect()->to('admin/home-story');
        }

        $this->viewData['edit_row'] = $edit_row;
        $this->viewData['form_action'] = 'admin/home-story/edit/' . $id . '/handle';
        $this->viewData['inputs'] = [
            'title' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'title', 'name' => 'title', 'placeholder' => 'عنوان استوری'],
                'type' => 'text'
            ],
            'type' => [
                'input' => 'form_dropdown',
                'data' => ['class' => 'form-control', 'id' => 'type', 'name' => 'type'],
                'options' => [
                    'image' => 'تصویر',
                    'video' => 'ویدئو'
                ]
            ],
            'avatar' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'avatar', 'name' => 'avatar', 'type' => 'file', 'accept' => 'image/*'],
                'type' => 'file'
            ],
            'url' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'url', 'name' => 'url', 'type' => 'file', 'accept' => 'image/*,video/*'],
                'type' => 'file'
            ],
            'duration' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'duration', 'name' => 'duration', 'placeholder' => 'مدت زمان (میلی‌ثانیه) - فقط برای تصویر', 'type' => 'number', 'min' => 0],
                'type' => 'number'
            ],
            'link' => [
                'input' => 'form_input',
                'data' => ['class' => 'form-control', 'id' => 'link', 'name' => 'link', 'placeholder' => 'لینک (اختیاری)'],
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
            'type' => 'نوع',
            'avatar' => 'تصویر آواتار',
            'url' => 'فایل اصلی',
            'duration' => 'مدت زمان (میلی‌ثانیه)',
            'link' => 'لینک',
            'sort_order' => 'ترتیب',
            'is_active' => 'وضعیت'
        ];

        return view('admin/home_story/create', $this->viewData);
    }

    public function formHandler($task, $id = 0)
    {
        if (!in_array($task, ['create', 'edit'])) {
            return redirect()->to('admin/home-story');
        }

        helper('sanitize');
        $validation = \Config\Services::validation();
        $homeStoryModel = model('App\Models\HomeStoryModel');

        $rules = [
            'title' => [
                'label' => 'عنوان',
                'rules' => 'required|min_length[2]|max_length[255]'
            ],
            'type' => [
                'label' => 'نوع',
                'rules' => 'required|in_list[image,video]'
            ],
            'duration' => [
                'label' => 'مدت زمان',
                'rules' => 'permit_empty|integer|greater_than_equal_to[0]'
            ],
            'link' => [
                'label' => 'لینک',
                'rules' => 'permit_empty|max_length[500]'
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

        // قوانین فایل‌ها (اجباری برای create، اختیاری برای edit)
        if ($task == 'create') {
            $rules['avatar'] = [
                'label' => 'تصویر آواتار',
                'rules' => 'uploaded[avatar]|is_image[avatar]|max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png,gif,webp]'
            ];
            $rules['url'] = [
                'label' => 'فایل اصلی',
                'rules' => 'uploaded[url]|max_size[url,10240]|ext_in[url,jpg,jpeg,png,gif,webp,mp4,mov,avi]'
            ];
        } else {
            $rules['avatar'] = [
                'label' => 'تصویر آواتار',
                'rules' => 'permit_empty|is_image[avatar]|max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png,gif,webp]'
            ];
            $rules['url'] = [
                'label' => 'فایل اصلی',
                'rules' => 'permit_empty|max_size[url,10240]|ext_in[url,jpg,jpeg,png,gif,webp,mp4,mov,avi]'
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
            'type' => $this->request->getPost('type', FILTER_SANITIZE_STRING),
            'duration' => $this->request->getPost('duration') ? (int) $this->request->getPost('duration') : null,
            'link' => $this->request->getPost('link', FILTER_SANITIZE_STRING),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?: 0),
            'is_active' => (int) $this->request->getPost('is_active', FILTER_VALIDATE_INT),
            'updated_at' => time()
        ];

        // پردازش آپلود فایل‌ها
        $uploadPath = FCPATH . 'images/home/story/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // آپلود آواتار
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($avatarFile->isValid()) {
                $avatarName = time() . '_avatar_' . $avatarFile->getClientName();
                $avatarFile->move($uploadPath, $avatarName);
                $model_data['avatar'] = 'home/story/' . $avatarName;
            }
        } elseif ($task == 'edit') {
            // در ویرایش، اگر فایل جدید نیومد، مقدار قبلی رو نگه دار
            $edit_row = $homeStoryModel->find($id);
            if ($edit_row && !empty($edit_row['avatar'])) {
                $model_data['avatar'] = $edit_row['avatar'];
            }
        }

        // آپلود فایل اصلی (url)
        $urlFile = $this->request->getFile('url');
        if ($urlFile && $urlFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if ($urlFile->isValid()) {
                $urlName = time() . '_url_' . $urlFile->getClientName();
                $urlFile->move($uploadPath, $urlName);
                $model_data['url'] = 'home/story/' . $urlName;
            }
        } elseif ($task == 'edit') {
            $edit_row = $homeStoryModel->find($id);
            if ($edit_row && !empty($edit_row['url'])) {
                $model_data['url'] = $edit_row['url'];
            }
        }

        // ذخیره
        if ($task == 'create') {
            $model_data['created_at'] = time();
            $storyId = $homeStoryModel->insert($model_data);

            if (!$storyId) {
                $this->flash('story_create_error');
                return redirect()->to('admin/home-story/create');
            }
        } else {
            $storyId = $id;
            $update_result = $homeStoryModel->update($storyId, $model_data);

            if (!$update_result) {
                $this->flash('story_update_error');
                return redirect()->to('admin/home-story/edit/' . $storyId);
            }
        }

        if ($task == 'create') {
            $this->flash('story_create_success');
        } else {
            $this->flash('story_update_success');
        }

        return redirect()->to('admin/home-story');
    }

    public function delete($id)
    {
        $homeStoryModel = model('App\Models\HomeStoryModel');
        $story = $homeStoryModel->find($id);

        if (!$story) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'استوری یافت نشد'
            ]);
        }

        try {
            // حذف فایل‌های فیزیکی
            $uploadPath = FCPATH . 'images/home/story/';

            if (!empty($story['avatar'])) {
                $avatarPath = $uploadPath . basename($story['avatar']);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }

            if (!empty($story['url'])) {
                $urlPath = $uploadPath . basename($story['url']);
                if (file_exists($urlPath)) {
                    unlink($urlPath);
                }
            }

            if ($homeStoryModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'استوری با موفقیت حذف شد'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'خطا در حذف استوری'
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
        $homeStoryModel = model('App\Models\HomeStoryModel');
        $story = $homeStoryModel->find($id);

        if (!$story) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'استوری یافت نشد'
            ]);
        }

        $newStatus = $story['is_active'] == 1 ? 0 : 1;

        if ($homeStoryModel->update($id, ['is_active' => $newStatus])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'وضعیت استوری با موفقیت تغییر کرد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در تغییر وضعیت'
            ]);
        }
    }
}