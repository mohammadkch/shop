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

    // ==============================================
    // روت‌های پنل کاربری (نیازمند لاگین)
    // ==============================================
    $routes->group('customer', ['filter' => 'customer_auth'], function($routes) {
        $routes->get('', 'Customer\Dashboard::index');
        $routes->get('dashboard', 'Customer\Dashboard::index');
        $routes->get('profile', 'Customer\Profile::index');
        $routes->post('profile/update', 'Customer\Profile::update');
        $routes->post('profile/change-password', 'Customer\Profile::changePassword');
    });

    // ==============================================
    // روت‌های checkout (نیازمند لاگین)
    // ==============================================
    $routes->group('checkout', ['filter' => 'customer_auth'], function($routes) {
        $routes->get('shipping', 'Checkout::shipping');
        $routes->get('shipping/(:num)', 'Checkout::shipping/$1');
        $routes->post('save-shipping', 'Checkout::saveShipping');
        $routes->post('add-address', 'Checkout::addAddress');
        $routes->post('delete-address', 'Checkout::deleteAddress');
        $routes->post('get-shipping-prices', 'Checkout::getShippingPrices');
        $routes->get('get-cities/(:num)', 'Checkout::getCities/$1');
        $routes->get('payment/(:num)', 'Checkout::payment/$1');
    });

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
    $routes->get('cart/proceed-to-checkout', 'Cart::proceedToCheckout');

    // ==============================================
    // روت‌های لاگین (عمومی)
    // ==============================================
    $routes->get('login', 'Auth\Login::index');
    $routes->post('login/check-mobile', 'Auth\Login::checkMobile');
    $routes->post('login/verify-otp', 'Auth\Login::verifyOtp');
    $routes->post('login/password', 'Auth\Login::loginWithPassword');
    $routes->get('customer/complete-profile', 'Auth\Login::completeProfile');
    $routes->post('login/save-profile', 'Auth\Login::saveProfile');
    $routes->get('logout', 'Auth\Login::logout');


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

    // product
    $routes->get('product', 'Product::index');
    $routes->post('product', 'Product::index');
    $routes->get('product/create', 'Product::create');
    $routes->post('product/create/handle', 'Product::create/handle');
    $routes->get('product/edit/(:num)', 'Product::edit/$1');
    $routes->post('product/edit/(:num)/handle', 'Product::edit/$1/handle');
    $routes->delete('product/delete/(:num)', 'Product::delete/$1');
    $routes->post('product/toggleActive/(:num)', 'Product::toggleActive/$1');

    // product-image
    $routes->get('product-image/manage/(:num)', 'ProductImage::manage/$1');
    $routes->post('product-image/manage/(:num)', 'ProductImage::manage/$1');
    $routes->post('product-image/toggleActive/(:num)', 'ProductImage::toggleActive/$1');
    $routes->delete('product-image/delete/(:num)', 'ProductImage::delete/$1');
    $routes->post('product-image/updateAlt/(:num)', 'ProductImage::updateAlt/$1');
    $routes->get('product-image/create/(:num)', 'ProductImage::create/$1');
    $routes->post('product-image/create/(:num)', 'ProductImage::create/$1');

    // ======== Product Menu3 ========
    $routes->get('product-menu3/manage/(:num)', 'ProductMenu3::manage/$1');
    $routes->post('product-menu3/manage/(:num)', 'ProductMenu3::manage/$1');
    $routes->post('product-menu3/update/(:num)', 'ProductMenu3::update/$1');
    $routes->delete('product-menu3/delete/(:num)', 'ProductMenu3::delete/$1');
    $routes->get('product-menu3/getMenu2/(:num)', 'ProductMenu3::getMenu2/$1');
    $routes->get('product-menu3/getMenu3/(:num)', 'ProductMenu3::getMenu3/$1');
    $routes->get('product-menu3/create/(:num)', 'ProductMenu3::create/$1');
    $routes->post('product-menu3/create/(:num)', 'ProductMenu3::create/$1');

    // ======== Product Option ========
    $routes->get('product-option/form/(:num)', 'ProductOption::form/$1');
    $routes->post('product-option/form/(:num)', 'ProductOption::form/$1');

    // ======== Home Story ========
    $routes->get('home-story', 'HomeStory::index');
    $routes->post('home-story', 'HomeStory::index');
    $routes->get('home-story/create', 'HomeStory::create');
    $routes->post('home-story/create/handle', 'HomeStory::create/handle');
    $routes->get('home-story/edit/(:num)', 'HomeStory::edit/$1');
    $routes->post('home-story/edit/(:num)/handle', 'HomeStory::edit/$1/handle');
    $routes->delete('home-story/delete/(:num)', 'HomeStory::delete/$1');
    $routes->post('home-story/toggleActive/(:num)', 'HomeStory::toggleActive/$1');

    // ======== Home Slider ========
    $routes->get('home-slider', 'HomeSlider::index');
    $routes->post('home-slider', 'HomeSlider::index');
    $routes->get('home-slider/create', 'HomeSlider::create');
    $routes->post('home-slider/create/handle', 'HomeSlider::create/handle');
    $routes->get('home-slider/edit/(:num)', 'HomeSlider::edit/$1');
    $routes->post('home-slider/edit/(:num)/handle', 'HomeSlider::edit/$1/handle');
    $routes->delete('home-slider/delete/(:num)', 'HomeSlider::delete/$1');
    $routes->post('home-slider/toggleActive/(:num)', 'HomeSlider::toggleActive/$1');

    // ======== Home Selected Category ========
    $routes->get('home-selected-category/manage', 'HomeSelectedCategory::manage');
    $routes->post('home-selected-category/manage', 'HomeSelectedCategory::manage');
    $routes->get('home-selected-category/create', 'HomeSelectedCategory::create');
    $routes->post('home-selected-category/create/handle', 'HomeSelectedCategory::create/handle');
    $routes->delete('home-selected-category/delete/(:num)', 'HomeSelectedCategory::delete/$1');
    $routes->post('home-selected-category/toggleActive/(:num)', 'HomeSelectedCategory::toggleActive/$1');
    $routes->get('home-selected-category/getMenu2/(:num)', 'HomeSelectedCategory::getMenu2/$1');
    $routes->get('home-selected-category/getMenu3/(:num)', 'HomeSelectedCategory::getMenu3/$1');
});


