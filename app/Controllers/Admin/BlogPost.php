<?php

namespace App\Controllers\Admin;

class BlogPost extends BaseController
{
    private const STATUSES = [
        'draft' => 'پیش‌نویس',
        'published' => 'منتشرشده',
        'scheduled' => 'زمان‌بندی‌شده',
        'archived' => 'بایگانی‌شده',
    ];

    public function index()
    {
        helper('sanitize');
        $model = model('App\Models\BlogPostModel');
        $categoryModel = model('App\Models\BlogCategoryModel');
        $pager = service('pager');
        $page = max(1, (int) ($this->request->getPost('page') ?? $this->request->getGet('page')));
        $filters = [
            'title' => $this->request->getPost('title', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']),
            'status' => $this->request->getPost('status', FILTER_SANITIZE_STRING),
            'blog_category_id' => $this->request->getPost('blog_category_id', FILTER_VALIDATE_INT),
        ];
        $perPage = 10;
        $total = $model->adminData($filters, null, 0, true);

        $this->viewData['rowset'] = $model->adminData($filters, $perPage, ($page - 1) * $perPage);
        $this->viewData['pagination'] = $pager->makeLinks($page, $perPage, $total, 'admin_pagination');
        $this->viewData['statuses'] = self::STATUSES;
        $this->viewData['categories'] = $categoryModel->orderBy('name')->findAll();

        if ($this->request->isAJAX()) {
            return view('admin/blog_post/index_data_table', $this->viewData);
        }
        return view('admin/blog_post/index', $this->viewData);
    }

    public function create()
    {
        return $this->form();
    }

    public function edit(int $id)
    {
        $post = model('App\Models\BlogPostModel')->find($id);
        if (!$post) {
            return redirect()->to('admin/blog-post')->with('error', 'مقاله پیدا نشد.');
        }
        return $this->form($post);
    }

    private function form(?array $post = null)
    {
        helper('form');

        $this->viewData['edit_row'] = $post;
        $this->viewData['blocks'] = $post
            ? model('App\Models\BlogPostBlockModel')->where('blog_post_id', $post['id'])->orderBy('sort_order')->findAll()
            : [];
        $this->viewData['categories'] = model('App\Models\BlogCategoryModel')->where('is_active', 1)->orderBy('name')->findAll();
        $this->viewData['users'] = model('App\Models\Admin\UserModel')->where('is_active', 1)->orderBy('full_name')->findAll();
        $this->viewData['statuses'] = self::STATUSES;
        $this->viewData['form_action'] = $post
            ? 'admin/blog-post/edit/' . $post['id']
            : 'admin/blog-post/create';
        return view('admin/blog_post/form', $this->viewData);
    }

    public function store()
    {
        return $this->savePost();
    }

    public function update(int $id)
    {
        return $this->savePost($id);
    }

    private function savePost(?int $id = null)
    {
        helper(['blog_content']);
        $postModel = model('App\Models\BlogPostModel');
        $blockModel = model('App\Models\BlogPostBlockModel');
        $existing = $id ? $postModel->find($id) : null;
        if ($id && !$existing) {
            return redirect()->to('admin/blog-post')->with('error', 'مقاله پیدا نشد.');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'slug' => 'permit_empty|max_length[255]',
            'user_id' => 'required|is_natural_no_zero',
            'blog_category_id' => 'required|is_natural_no_zero',
            'excerpt' => 'required|min_length[10]|max_length[1000]',
            'featured_image_alt' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[draft,published,scheduled,archived]',
            'published_at' => 'permit_empty',
            'meta_title' => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[320]',
            'canonical_url' => 'permit_empty|valid_url_strict|max_length[500]',
            'featured_image' => 'permit_empty|is_image[featured_image]|max_size[featured_image,4096]|ext_in[featured_image,jpg,jpeg,png,webp]',
        ];
        if (!$this->validate($rules)) {
            $this->viewData['validation_errors'] = service('validation')->getErrors();
            return $this->form($existing);
        }

        $slug = $this->cleanSlug((string) $this->request->getPost('slug'));
        if ($slug === '') {
            $slug = $this->cleanSlug((string) $this->request->getPost('title'));
        }
        $slugQuery = $postModel->where('slug', $slug);
        if ($id) {
            $slugQuery->where('id !=', $id);
        }
        if ($slugQuery->first()) {
            $this->viewData['validation_errors'] = ['slug' => 'این slug قبلاً استفاده شده است.'];
            return $this->form($existing);
        }

        $status = (string) $this->request->getPost('status');
        $publishedAt = $this->parseDateTime((string) $this->request->getPost('published_at'));
        if (in_array($status, ['published', 'scheduled'], true) && !$publishedAt) {
            $this->viewData['validation_errors'] = ['published_at' => 'برای انتشار یا زمان‌بندی، زمان انتشار الزامی است.'];
            return $this->form($existing);
        }

        $featuredImage = $existing['featured_image'] ?? null;
        $uploadedFeatured = null;
        $file = $this->request->getFile('featured_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadedFeatured = $this->moveImage($file, 'featured');
            $featuredImage = $uploadedFeatured;
        }

        $data = [
            'user_id' => (int) $this->request->getPost('user_id'),
            'blog_category_id' => (int) $this->request->getPost('blog_category_id'),
            'title' => trim(strip_tags((string) $this->request->getPost('title'))),
            'slug' => $slug,
            'excerpt' => trim(strip_tags((string) $this->request->getPost('excerpt'))),
            'featured_image' => $featuredImage,
            'featured_image_alt' => trim(strip_tags((string) $this->request->getPost('featured_image_alt'))),
            'status' => $status,
            'published_at' => $publishedAt,
            'meta_title' => trim(strip_tags((string) $this->request->getPost('meta_title'))),
            'meta_description' => trim(strip_tags((string) $this->request->getPost('meta_description'))),
            'canonical_url' => trim((string) $this->request->getPost('canonical_url')) ?: null,
        ];

        $db = db_connect();
        $db->transStart();
        if ($id) {
            $postModel->update($id, $data);
            $postId = $id;
        } else {
            $postId = (int) $postModel->insert($data, true);
        }

        $oldBlocks = $id ? $blockModel->where('blog_post_id', $postId)->findAll() : [];
        $oldById = array_column($oldBlocks, null, 'id');
        $keptIds = [];
        $uploadedBlockImages = [];
        $obsoleteImages = [];
        $types = (array) $this->request->getPost('block_type');
        $contents = (array) $this->request->getPost('block_content');
        $blockIds = (array) $this->request->getPost('block_id');
        $alts = (array) $this->request->getPost('block_image_alt');
        $captions = (array) $this->request->getPost('block_caption');
        $files = $this->request->getFiles()['block_image'] ?? [];

        foreach ($types as $index => $type) {
            if (!in_array($type, ['text', 'image', 'text_image'], true)) {
                continue;
            }
            $blockId = (int) ($blockIds[$index] ?? 0);
            $oldBlock = $oldById[$blockId] ?? null;
            $image = $oldBlock['image'] ?? null;
            $blockFile = $files[$index] ?? null;
            if ($blockFile && $blockFile->isValid() && !$blockFile->hasMoved()) {
                if (!in_array(strtolower($blockFile->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true)
                    || $blockFile->getSizeByUnit('kb') > 4096
                    || !@getimagesize($blockFile->getTempName())) {
                    $db->transRollback();
                    $this->deleteMedia($uploadedFeatured);
                    foreach ($uploadedBlockImages as $uploaded) {
                        $this->deleteMedia($uploaded);
                    }
                    return redirect()->back()->withInput()->with('error', 'یکی از تصاویر بلاک معتبر نیست یا بیشتر از ۴ مگابایت است.');
                }
                $image = $this->moveImage($blockFile, 'blocks');
                $uploadedBlockImages[] = $image;
                if (!empty($oldBlock['image'])) {
                    $obsoleteImages[] = $oldBlock['image'];
                }
            }
            $content = sanitizeBlogHtml($contents[$index] ?? '');
            if (($type === 'text' && $content === '') || ($type === 'image' && !$image)
                || ($type === 'text_image' && ($content === '' || !$image))) {
                continue;
            }
            $blockData = [
                'blog_post_id' => $postId,
                'type' => $type,
                'content' => in_array($type, ['text', 'text_image'], true) ? $content : null,
                'image' => in_array($type, ['image', 'text_image'], true) ? $image : null,
                'image_alt' => trim(strip_tags($alts[$index] ?? '')),
                'caption' => trim(strip_tags($captions[$index] ?? '')),
                'sort_order' => $index + 1,
            ];
            if ($oldBlock) {
                $blockModel->update($blockId, $blockData);
                $keptIds[] = $blockId;
            } else {
                $keptIds[] = (int) $blockModel->insert($blockData, true);
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
            $this->deleteMedia($uploadedFeatured);
            foreach ($uploadedBlockImages as $uploaded) {
                $this->deleteMedia($uploaded);
            }
            return redirect()->back()->withInput()->with('error', 'ذخیره مقاله با خطا روبه‌رو شد.');
        }
        if ($uploadedFeatured && !empty($existing['featured_image'])) {
            $this->deleteMedia($existing['featured_image']);
        }
        foreach (array_unique($obsoleteImages) as $obsoleteImage) {
            $this->deleteMedia($obsoleteImage);
        }
        return redirect()->to('admin/blog-post')->with('success', $id ? 'مقاله بروزرسانی شد.' : 'مقاله ساخته شد.');
    }

    public function toggleStatus(int $id)
    {
        $model = model('App\Models\BlogPostModel');
        $post = $model->find($id);
        if (!$post) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'مقاله پیدا نشد.']);
        }
        $newStatus = $post['status'] === 'published' ? 'draft' : 'published';
        $data = ['status' => $newStatus];
        if ($newStatus === 'published' && empty($post['published_at'])) {
            $data['published_at'] = time();
        }
        $model->update($id, $data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'وضعیت مقاله تغییر کرد.']);
    }

    public function delete(int $id)
    {
        $postModel = model('App\Models\BlogPostModel');
        $post = $postModel->find($id);
        if (!$post) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'مقاله پیدا نشد.']);
        }
        $blocks = model('App\Models\BlogPostBlockModel')->where('blog_post_id', $id)->findAll();
        if (!$postModel->delete($id)) {
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'حذف مقاله انجام نشد.']);
        }
        $this->deleteMedia($post['featured_image']);
        foreach ($blocks as $block) {
            $this->deleteMedia($block['image']);
        }
        return $this->response->setJSON(['status' => 'success', 'message' => 'مقاله حذف شد.']);
    }

    private function cleanSlug(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/[^\p{L}\p{N}\s_-]+/u', '', $value);
        return trim(preg_replace('/[\s_]+/u', '-', $value), '-');
    }

    private function parseDateTime(string $value): ?int
    {
        if (trim($value) === '') {
            return null;
        }
        $date = \DateTime::createFromFormat('Y-m-d\TH:i', $value, new \DateTimeZone('Asia/Tehran'));
        return $date ? $date->getTimestamp() : null;
    }

    private function moveImage($file, string $folder): string
    {
        $relative = 'blog/' . $folder . '/' . $file->getRandomName();
        $target = FCPATH . 'images/blog/' . $folder;
        if (!is_dir($target)) {
            mkdir($target, 0775, true);
        }
        $file->move($target, basename($relative));
        return str_replace('\\', '/', $relative);
    }

    private function deleteMedia(?string $relative): void
    {
        if (!$relative || !str_starts_with($relative, 'blog/')) {
            return;
        }
        $path = realpath(FCPATH . 'images/' . $relative);
        $root = realpath(FCPATH . 'images/blog');
        if ($path && $root && str_starts_with($path, $root . DIRECTORY_SEPARATOR) && is_file($path)) {
            unlink($path);
        }
    }
}
