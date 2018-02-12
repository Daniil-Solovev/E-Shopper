<?php

// FRONT CONTROLLER

// Подключение файлов системы

session_start();

define('ROOT', dirname(__FILE__));
require_once(ROOT. '/components/Autoload.php');
require_once(ROOT. '/vendor/autoload.php');

// Установка соединения с БД


// Вызор Router

$router = new Router();
$router->run();