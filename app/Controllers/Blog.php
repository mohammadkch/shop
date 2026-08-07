<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        helper('menu');
        $model = model('App\Models\BlogPostModel');
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 12;
        $countBuilder = $model->publicBuilder();
        $total = $countBuilder->countAllResults();
        $posts = $model->publicBuilder()
            ->orderBy('post.published_at', 'DESC')
            ->limit($perPage, ($page - 1) * $perPage)
            ->get()->getResultArray();

        $this->viewData['posts'] = $posts;
        $this->viewData['pagination'] = service('pager')->makeLinks($page, $perPage, $total, 'shop_pagination');
        $this->viewData['title'] = 'مجله مد و پوشاک';
        $this->viewData['metaDescription'] = 'مقالات مد، استایل، راهنمای خرید و نگهداری پوشاک';
        $this->viewData['canonicalUrl'] = site_url('blog') . ($page > 1 ? '?page=' . $page : '');
        return view('blog/index', $this->viewData);
    }

    public function show(string $slug)
    {
        helper('menu');
        $post = model('App\Models\BlogPostModel')->publicBuilder()
            ->where('post.slug', $slug)
            ->get()->getRowArray();
        if (!$post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $sessionKey = 'viewed_blog_posts';
        $viewed = (array) session()->get($sessionKey);
        if (!in_array((int) $post['id'], $viewed, true)) {
            db_connect()->table('blog_post')->where('id', $post['id'])->increment('view_count');
            $viewed[] = (int) $post['id'];
            session()->set($sessionKey, array_slice($viewed, -100));
            $post['view_count']++;
        }

        $postModel = model('App\Models\BlogPostModel');
        $this->viewData['post'] = $post;
        $this->viewData['blocks'] = model('App\Models\BlogPostBlockModel')
            ->where('blog_post_id', $post['id'])->orderBy('sort_order')->findAll();
        $this->viewData['latestPosts'] = $postModel->publicBuilder()
            ->where('post.id !=', $post['id'])->orderBy('post.published_at', 'DESC')->limit(5)->get()->getResultArray();
        $this->viewData['popularPosts'] = $postModel->publicBuilder()
            ->where('post.id !=', $post['id'])->orderBy('post.view_count', 'DESC')->orderBy('post.published_at', 'DESC')
            ->limit(5)->get()->getResultArray();
        $this->viewData['title'] = ($post['meta_title'] ?: $post['title']);
        $this->viewData['metaDescription'] = $post['meta_description'] ?: $post['excerpt'];
        $this->viewData['canonicalUrl'] = $post['canonical_url'] ?: site_url('blog/' . $post['slug']);
        $this->viewData['ogImage'] = $post['featured_image'] ? base_url('images/' . $post['featured_image']) : null;
        $this->viewData['robots'] = 'index, follow';
        return view('blog/show', $this->viewData);
    }

}
