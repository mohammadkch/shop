<?php

namespace App\Controllers\Admin;

class ProductImage extends BaseController
{
    public function manage($productId)
    {

        $productId = (int) $productId;

        if ($productId < 1) {
            $this->flash('product_not_found', 'محصولی یافت نشد');
            return redirect()->to('admin/product');
        }

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصولی یافت نشد');
            return redirect()->to('admin/product');
        }

        $productImageModel = model('App\Models\ProductImageModel');
        $images = $productImageModel
            ->select('product_image.*, product_image_type.name as type_name')
            ->join('product_image_type', 'product_image_type.id = product_image.product_image_type_id')
            ->where('product_id', $productId)
            ->orderBy('product_image.is_active', 'DESC')
            ->orderBy('product_image.sort_order', 'ASC')
            ->findAll();

        $this->viewData['product'] = $product;
        $this->viewData['images'] = $images;
        $this->viewData['product_id'] = $productId;
        $this->viewData['title'] = 'مدیریت تصاویر - ' . $product['name'];

        if ($this->request->isAJAX()) {
            return view('admin/product_image/manage_table', $this->viewData);
        }

        return view('admin/product_image/manage', $this->viewData);
    }

    public function toggleActive($id)
    {
        $productImageModel = model('App\Models\ProductImageModel');
        $image = $productImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // اگه میخواد غیرفعال کنه (از 1 به 0)
        if ($image['is_active'] == 1) {
            // چک کن آیا تصویر فعال دیگه‌ای از همین تایپ برای این محصول وجود داره؟
            $activeCount = $productImageModel
                ->where('product_id', $image['product_id'])
                ->where('product_image_type_id', $image['product_image_type_id'])
                ->where('is_active', 1)
                ->where('id !=', $id)
                ->countAllResults();

            if ($activeCount == 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'حداقل یک تصویر از این نوع باید فعال باشد'
                ]);
            }

            // غیرفعال کن
            $productImageModel->update($id, ['is_active' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت غیرفعال شد'
            ]);
        }
        // اگه میخواد فعال کنه (از 0 به 1)
        else {
            $productImageModel->update($id, ['is_active' => 1]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'تصویر با موفقیت فعال شد'
            ]);
        }
    }

    public function delete($id)
    {
        $productImageModel = model('App\Models\ProductImageModel');
        $image = $productImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        // فقط تصاویر غیرفعال قابل حذف هستن
        if ($image['is_active'] == 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر فعال قابل حذف نیست. ابتدا آن را غیرفعال کنید.'
            ]);
        }

        // حذف فایل فیزیکی
        if (!empty($image['image_name'])) {
            $imageTypeModel = model('App\Models\ProductImageTypeModel');
            $type = $imageTypeModel->find($image['product_image_type_id']);

            if ($type && !empty($type['path'])) {
                $filePath = FCPATH . $type['path'] . '/' . $image['image_name'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        if ($productImageModel->delete($id)) {
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

    public function updateAlt($id)
    {
        $productImageModel = model('App\Models\ProductImageModel');
        $image = $productImageModel->find($id);

        if (!$image) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'تصویر یافت نشد'
            ]);
        }

        $alt = $this->request->getJSON()->alt ?? '';

        if ($productImageModel->update($id, ['alt' => $alt])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'متن جایگزین با موفقیت به‌روزرسانی شد'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'خطا در به‌روزرسانی'
            ]);
        }
    }

    public function create($productId)
    {
        $productId = (int) $productId;

        if ($this->request->getMethod() === 'POST') {
            return $this->formHandler($productId);
        }

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);

        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        // دریافت انواع تصاویر
        $imageTypeModel = model('App\Models\ProductImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $this->viewData['product'] = $product;
        $this->viewData['product_id'] = $productId;
        $this->viewData['imageTypes'] = $imageTypes;
        $this->viewData['title'] = 'افزودن عکس جدید - ' . $product['name'];
        $this->viewData['form_action'] = 'admin/product-image/create/' . $productId;

        return view('admin/product_image/create', $this->viewData);
    }

    public function formHandler($productId)
    {
        $productId = (int) $productId;

        $productModel = model('App\Models\ProductModel');
        $product = $productModel->find($productId);


        if (!$product) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $imageTypeModel = model('App\Models\ProductImageTypeModel');
        $imageTypes = $imageTypeModel->where('is_active', 1)->findAll();

        $rules = [];
        $hasFileUpload = false;

        foreach ($imageTypes as $type) {
            $fileField = 'image_' . $type['id'];

            if ($this->request->getFile($fileField)->getError() !== UPLOAD_ERR_NO_FILE) {
                $hasFileUpload = true;
                $rules[$fileField] = [
                    'label' => $type['name'],
                    'rules' => 'is_image[' . $fileField . ']|max_size[' . $fileField . ',' . ($type['file_size_limit'] ?: 2048) . ']|ext_in[' . $fileField . ',' . str_replace('|', ',', $type['extension']) . ']'
                ];
            }

            // ======== ولیدیشن alt (اگه پر شده بود) ========
            $altField = 'alt_' . $type['id'];
            $altValue = $this->request->getPost($altField);
            if (!empty($altValue)) {
                $rules[$altField] = [
                    'label' => 'متن جایگزین ' . $type['name'],
                    'rules' => 'max_length[255]'
                ];
            }

            // ======== ولیدیشن sort_order (اگه پر شده بود) ========
            $sortField = 'sort_' . $type['id'];
            $sortValue = $this->request->getPost($sortField);
            if ($sortValue !== '' && $sortValue !== null) {
                $rules[$sortField] = [
                    'label' => 'ترتیب ' . $type['name'],
                    'rules' => 'integer|greater_than_equal_to[0]'
                ];
            }
        }


        if (!$hasFileUpload) {
            $this->flash('validation_error', 'حداقل یک تصویر باید آپلود شود');
            return redirect()->to('admin/product-image/create/' . $productId);
        }

        $validation = \Config\Services::validation();

        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = $validation->getErrors();
            // بازگرداندن به صفحه create با خطاها
            $this->viewData['product'] = $product;
            $this->viewData['product_id'] = $productId;
            $this->viewData['imageTypes'] = $imageTypes;
            $this->viewData['title'] = 'افزودن عکس جدید - ' . $product['name'];
            $this->viewData['form_action'] = 'admin/product-image/create/' . $productId;

            return view('admin/product_image/create', $this->viewData);
        }

        // ذخیره تصاویر
        $productImageModel = model('App\Models\ProductImageModel');
        $uploadedCount = 0;

        foreach ($imageTypes as $type) {
            $fileField = 'image_' . $type['id'];
            $file = $this->request->getFile($fileField);

            // اگه فایلی آپلود شده
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                // گرفتن alt
                $alt = $this->request->getPost('alt_' . $type['id']) ?? '';

                // مسیر ذخیره
                $uploadPath = FCPATH . $type['path'] . '/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // ذخیره فایل
                $newName = time() . '_' . $file->getClientName();
                $file->move($uploadPath, $newName);

                // ذخیره در دیتابیس (با is_active = 1)
                // ذخیره در دیتابیس
                $productImageModel->insert([
                    'product_image_type_id' => $type['id'],
                    'product_id' => $productId,
                    'image_name' => $newName,
                    'original_name' => $file->getClientName(),
                    'alt' => $alt,
                    'sort_order' => (int) ($this->request->getPost('sort_' . $type['id']) ?: 0),
                    'is_active' => 1,
                    'created_at' => time(),
                    'updated_at' => time()
                ]);

                $uploadedCount++;
            }
        }

        if ($uploadedCount > 0) {
            $this->flash('image_upload_success', $uploadedCount . ' تصویر با موفقیت آپلود شد');
        } else {
            $this->flash('image_upload_error', 'خطا در آپلود تصاویر');
        }

        return redirect()->to('admin/product-image/manage/' . $productId);
    }
}