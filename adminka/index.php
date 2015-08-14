<?php
//Переменная доступа
define('ACCESS_VALUE', 'LegoShop');
define(ACCESS_VALUE, TRUE);

session_start();

//Подключение файла конфигурации
require_once '../config.php';

// Подключаем контроллер
require_once CONTROLLER;


