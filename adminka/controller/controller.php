<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Подключаем модель
require_once MODEL;

// подключение библиотеки функций
require_once '../functions/functions.php';
require_once '../functions/classSimpleImage.php';

//Подключение классов Объектов(модели)
require_once '../model/Accessory.php';
require_once '../model/Article.php';
require_once '../model/Category.php';
require_once '../model/Infopage.php';
require_once '../model/Product.php';
require_once '../model/Order.php';
require_once '../model/Label.php';

//Обработка ajax запросов
if(isset($_GET['ajax'])){
    $view = $_GET['ajax'];
    //Подключаем вид
    require_once VIEW.'ajax/'.$view.'.php';
    die();
}

//Переключение видов
if(isset($_GET['view'])){
    $view = $_GET['view'];
}
else{
    $view = 'info_pages';
}
//Подключаем вид
require_once VIEW.'index.php';
