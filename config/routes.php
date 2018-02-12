<?php

// Правила маршрутов
return array(
    //
    'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController
    'catalog' => 'catalog/index', // actionIndex в CatalogController

    // Категории товаров
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory в CatalogController

    // Корзина
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete в CartController
    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAjax в CartController
    'cart' => 'cart/index', // actionIndex в CartController
    'checkout' => 'cart/checkout', // actionCheckout в CartController

    // Пользователь
    'user/register' => 'user/register', // actionRegister в UserController
    'user/login' => 'user/login', // actionLogin в UserController
    'user/logout' => 'user/logout', // actionLogout в UserController

    // Личный кабинет
    'cabinet/edit' => 'cabinet/edit', // actionEdit в CabinetController
    'cabinet' => 'cabinet/index', // actionIndex в CabinetController

    // Управление товарами:
    'admin/product/create' => 'adminProduct/create', // actionCreate в adminProductController
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',  // actionUpdate в adminProductController
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',  // actionDelete в adminProductController
    'admin/product' => 'adminProduct/index',  // actionIndex в adminProductController
    // Управление категориями:
    'admin/category/create' => 'adminCategory/create',  // actionCreate в adminCategoryController
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',  // actionUpdate  в adminCategoryController
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',  // actionDelete в adminCategoryController
    'admin/category' => 'adminCategory/index',  // actionIndex в adminCategoryController
    // Управление заказами:
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',  // actionUpdate в adminOrderController
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',  // actionDelete в adminOrderController
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',  // actionView в adminOrderController
    'admin/order' => 'adminOrder/index',  // actionIndex в adminOrderController
    // Админ-панель:
    'admin' => 'admin/index', // actionIndex в AdminController
    // Обратная связь
    'feedback' => 'site/feedback', // actionFeedback в SiteController

    // Стартовая страница
    '' => 'site/index', // actionIndex  в SiteController
);