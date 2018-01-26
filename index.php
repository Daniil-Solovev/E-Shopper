<?php

// FRONT COTROLLER

// 2. Подключение файлов системы

define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Router.php');
require_once (ROOT . '/components/Db.php');


// 3. Установка соединения с БД


// 4. Вызор Router

$router = new Router();
$router->run();