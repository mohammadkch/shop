<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------
// Testing routes
// --------------------
$routes->get('/dbtest', function () {
    $db = \Config\Database::connect();
    return "Platform: " . $db->getPlatform();
});

// --------------------
// shop routes
// --------------------

$routes->group('', ['filter' => 'parse_url'], function ($routes) {

    $routes->get('/', 'Home::index');
    $routes->get('home', 'Home::index');
    $routes->get('product/(:any)', 'Product::show/$1');

    // بعد روت‌های category (به ترتیب از طولانی‌ترین به کوتاه‌ترین)
    $routes->get('category/(:any)/(:any)/(:any)', 'Category::index/$1/$2/$3');
    $routes->get('category/(:any)/(:any)', 'Category::index/$1/$2');
    $routes->get('category/(:any)', 'Category::index/$1');

    // Cart routes
    $routes->get('cart', 'Cart::index');
    $routes->post('cart/add', 'Cart::add');
    $routes->post('cart/remove', 'Cart::remove');
    $routes->post('cart/update', 'Cart::update');
    $routes->get('cart/count', 'Cart::count');
    $routes->get('cart/offcanvas', 'Cart::offcanvas');
});

// --------------------
// shop admin routes
// --------------------
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'admin_auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');

    $routes->get('login', 'Login::index');
    $routes->post('login/authenticate', 'Login::authenticate');

    $routes->get('logout', 'Logout::index');
    $routes->post('logout', 'Logout::index');

    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('test', 'Test::index');

    // menu_1
    $routes->get('menu1', 'Menu1::index');
    $routes->post('menu1', 'Menu1::index');
    $routes->get('menu1/create', 'Menu1::create');
    $routes->post('menu1/create/handle', 'Menu1::create/handle');
    $routes->get('menu1/edit/(:num)', 'Menu1::edit/$1');
    $routes->post('menu1/edit/(:num)/handle', 'Menu1::edit/$1/handle');
    $routes->delete('menu1/delete/(:num)', 'Menu1::delete/$1');
    $routes->post('menu1/toggleActive/(:num)', 'Menu1::toggleActive/$1');

    // menu_1_image
    $routes->get('menu1-image', 'Menu1Image::index');
    $routes->post('menu1-image', 'Menu1Image::index');
    $routes->delete('menu1-image/delete/(:num)', 'Menu1Image::delete/$1');
    $routes->post('menu1-image/toggleActive/(:num)', 'Menu1Image::toggleActive/$1');

    // menu_2
    $routes->get('menu2', 'Menu2::index');
    $routes->post('menu2', 'Menu2::index');
    $routes->get('menu2/create', 'Menu2::create');
    $routes->post('menu2/create/handle', 'Menu2::create/handle');
    $routes->get('menu2/edit/(:num)', 'Menu2::edit/$1');
    $routes->post('menu2/edit/(:num)/handle', 'Menu2::edit/$1/handle');
    $routes->delete('menu2/delete/(:num)', 'Menu2::delete/$1');
    $routes->post('menu2/toggleActive/(:num)', 'Menu2::toggleActive/$1');

    // menu_2_image
    $routes->get('menu2-image', 'Menu2Image::index');
    $routes->post('menu2-image', 'Menu2Image::index');
    $routes->delete('menu2-image/delete/(:num)', 'Menu2Image::delete/$1');
    $routes->post('menu2-image/toggleActive/(:num)', 'Menu2Image::toggleActive/$1');

    // menu_3
    $routes->get('menu3', 'Menu3::index');
    $routes->post('menu3', 'Menu3::index');
    $routes->get('menu3/create', 'Menu3::create');
    $routes->post('menu3/create/handle', 'Menu3::create/handle');
    $routes->get('menu3/edit/(:num)', 'Menu3::edit/$1');
    $routes->post('menu3/edit/(:num)/handle', 'Menu3::edit/$1/handle');
    $routes->delete('menu3/delete/(:num)', 'Menu3::delete/$1');
    $routes->post('menu3/toggleActive/(:num)', 'Menu3::toggleActive/$1');
    $routes->get('menu3/getAllMenu2', 'Menu3::getAllMenu2');
    $routes->get('menu3/getMenu2ByMenu1/(:num)', 'Menu3::getMenu2ByMenu1/$1');

    // menu_3_image
    $routes->get('menu3-image', 'Menu3Image::index');
    $routes->post('menu3-image', 'Menu3Image::index');
    $routes->delete('menu3-image/delete/(:num)', 'Menu3Image::delete/$1');
    $routes->post('menu3-image/toggleActive/(:num)', 'Menu3Image::toggleActive/$1');
    $routes->get('menu3-image/getMenu2ByMenu1/(:num)', 'Menu3Image::getMenu2ByMenu1/$1');
    $routes->get('menu3-image/getMenu3ByMenu2/(:num)', 'Menu3Image::getMenu3ByMenu2/$1');
});


