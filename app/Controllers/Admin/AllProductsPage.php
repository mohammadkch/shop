<?php

namespace App\Controllers\Admin;

class AllProductsPage extends BaseController
{
    private const PAGE_ID = 1;

    public function edit()
    {
        helper('form');

        $this->viewData['page'] = model('App\Models\AllProductsPageModel')->find(self::PAGE_ID);
        $this->viewData['blocks'] = model('App\Models\AllProductsPageBlockModel')
            ->where('all_products_page_id', self::PAGE_ID)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['title'] = 'مدیریت صفحه همه محصولات';

        return view('admin/all_products_page/edit', $this->viewData);
    }

    public function update()
    {
        helper('blog_content');

        $rules = [
            'h1_title' => 'required|min_length[2]|max_length[255]',
            'meta_title' => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[320]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', service('validation')->getErrors()));
        }

        $pageModel = model('App\Models\AllProductsPageModel');
        $blockModel = model('App\Models\AllProductsPageBlockModel');
        $page = $pageModel->find(self::PAGE_ID);
        if (!$page) {
            return redirect()->back()->withInput()->with('error', 'تنظیمات صفحه همه محصولات پیدا نشد.');
        }

        $oldBlocks = $blockModel->where('all_products_page_id', self::PAGE_ID)->findAll();
        $oldById = array_column($oldBlocks, null, 'id');
        $types = (array) $this->request->getPost('block_type');
        $contents = (array) $this->request->getPost('block_content');
        $blockIds = (array) $this->request->getPost('block_id');
        $alts = (array) $this->request->getPost('block_image_alt');
        $captions = (array) $this->request->getPost('block_caption');
        $files = $this->request->getFiles()['block_image'] ?? [];
        $preparedBlocks = [];
        $uploadedImages = [];
        $obsoleteImages = [];

        foreach ($types as $index => $type) {
            if (!in_array($type, ['text', 'image', 'text_image'], true)) {
                continue;
            }

            $blockId = (int) ($blockIds[$index] ?? 0);
            $oldBlock = $oldById[$blockId] ?? null;
            $image = $oldBlock['image'] ?? null;
            $file = $files[$index] ?? null;

            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                if (!$file->isValid()
                    || !in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)
                    || $file->getSizeByUnit('kb') > 4096
                    || !@getimagesize($file->getTempName())) {
                    foreach ($uploadedImages as $uploaded) {
                        $this->deleteMedia($uploaded);
                    }
                    return redirect()->back()->withInput()->with('error', 'یکی از تصاویر معتبر نیست یا بیشتر از ۴ مگابایت است.');
                }

                $image = $this->moveImage($file);
                $uploadedImages[] = $image;
                if (!empty($oldBlock['image'])) {
                    $obsoleteImages[] = $oldBlock['image'];
                }
            }

            $content = sanitizeBlogHtml($contents[$index] ?? '');
            if ($type === 'text' && !empty($oldBlock['image'])) {
                $obsoleteImages[] = $oldBlock['image'];
            }
            if (($type === 'text' && $content === '')
                || ($type === 'image' && !$image)
                || ($type === 'text_image' && ($content === '' || !$image))) {
                continue;
            }

            $preparedBlocks[] = [
                'id' => $oldBlock ? (int) $oldBlock['id'] : null,
                'all_products_page_id' => self::PAGE_ID,
                'type' => $type,
                'content' => $type !== 'image' ? $content : null,
                'image' => $type !== 'text' ? $image : null,
                'image_alt' => trim(strip_tags((string) ($alts[$index] ?? ''))) ?: null,
                'caption' => trim(strip_tags((string) ($captions[$index] ?? ''))) ?: null,
                'sort_order' => count($preparedBlocks) + 1,
            ];
        }

        $db = db_connect();
        $db->transStart();
        $pageModel->update(self::PAGE_ID, [
            'h1_title' => trim(strip_tags((string) $this->request->getPost('h1_title'))),
            'meta_title' => trim(strip_tags((string) $this->request->getPost('meta_title'))) ?: null,
            'meta_description' => trim(strip_tags((string) $this->request->getPost('meta_description'))) ?: null,
        ]);

        $keptIds = [];
        foreach ($preparedBlocks as $block) {
            $blockId = $block['id'];
            unset($block['id']);
            if ($blockId) {
                $blockModel->update($blockId, $block);
                $keptIds[] = $blockId;
            } else {
                $keptIds[] = (int) $blockModel->insert($block, true);
            }
        }

        foreach ($oldBlocks as $oldBlock) {
            if (!in_array((int) $oldBlock['id'], $keptIds, true)) {
                $blockModel->delete($oldBlock['id']);
                if (!empty($oldBlock['image'])) {
                    $obsoleteImages[] = $oldBlock['image'];
                }
            }
        }
        $db->transComplete();

        if (!$db->transStatus()) {
            foreach ($uploadedImages as $uploaded) {
                $this->deleteMedia($uploaded);
            }
            return redirect()->back()->withInput()->with('error', 'ذخیره تنظیمات صفحه انجام نشد.');
        }

        foreach (array_unique($obsoleteImages) as $obsolete) {
            $this->deleteMedia($obsolete);
        }

        return redirect()->to(ADMIN_PATH . '/all-products-page')->with('success', 'صفحه همه محصولات بروزرسانی شد.');
    }

    private function moveImage($file): string
    {
        $name = $file->getRandomName();
        $target = FCPATH . 'images/category/all-products';
        if (!is_dir($target)) {
            mkdir($target, 0775, true);
        }
        $file->move($target, $name);
        return 'category/all-products/' . $name;
    }

    private function deleteMedia(?string $relative): void
    {
        if (!$relative || !str_starts_with($relative, 'category/all-products/')) {
            return;
        }
        $path = realpath(FCPATH . 'images/' . $relative);
        $root = realpath(FCPATH . 'images/category/all-products');
        if ($path && $root && str_starts_with($path, $root . DIRECTORY_SEPARATOR) && is_file($path)) {
            unlink($path);
        }
    }
}
