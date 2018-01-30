<?php

// FRONT COTROLLER

// 2. Подключение файлов системы



session_start();

define('ROOT', dirname(__FILE__));
require_once(ROOT. '/components/Autoload.php');
require_once(ROOT. '/vendor/autoload.php');


// 3. Установка соединения с БД


// 4. Вызор Router

$router = new Router();
$router->run();