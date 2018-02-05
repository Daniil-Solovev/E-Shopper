<?php

// Правила маршрутов
return array(
    'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController
    'catalog' => 'catalog/index', // actionIndex в CatalogController

    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory в CatalogController

    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController

    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAjax в CartController
    'cart' => 'cart/index', // actionIndex в CartController
    'checkout' => 'cart/checkout', // actionCheckout в CartController

    'user/register' => 'user/register', // actionRegister в UserController
    'user/login' => 'user/login', // actionLogin в UserController
    'user/logout' => 'user/logout', // actionLogout в UserController

    'cabinet/edit' => 'cabinet/edit', // actionEdit в CabinetController
    'cabinet' => 'cabinet/index', // actionIndex в CabinetController

    'feedback' => 'site/feedback', // actionFeedback в SiteController

    '' => 'site/index', // actionIndex  в SiteController
);