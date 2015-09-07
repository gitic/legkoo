<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//домен
define('PATH', 'http://localhost/lego');

//админка
define('ADMIN', PATH.'adminka/');

//Контент
define('CONTENT', 'content/');

//модель
define('MODEL', 'model/model.php');

//контроллер
define('CONTROLLER', 'controller/controller.php');

//вид
define('VIEW', 'view/');

//email адрес сайта
define('MAIL', 'legkoo.com.ua');

//пароль к почтовому аккаунту
define('MAIL_PASS', 'mlqricettio777mlq');

//сервер БД
define('HOST', 'localhost');

//пользователь
define('DB_USER', 'ricettio');

//пароль
define('PASS', 'qricettio777q');

//БД
define('DB_NAME', 'lego');

//название
define('TITLE', 'Legkoo.com.ua');

//Установка временной зоны сервера
if (function_exists('date_default_timezone_set')){
    date_default_timezone_set('Europe/Kiev');  
}

// Create connection
$conn = new mysqli(HOST, DB_USER , PASS, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("SET NAMES utf8");
$conn->query("SET time_zone = '+2:00'");
