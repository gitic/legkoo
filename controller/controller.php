<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Подключаем модель
require_once MODEL;

// подключение библиотеки функций
require_once 'functions/functions.php';
require_once 'functions/classSimpleImage.php';

//require_once 'model/autoload.php';
require_once 'model/Accessory.php';
require_once 'model/Article.php';
require_once 'model/Category.php';
require_once 'model/Infopage.php';
require_once 'model/Product.php';
require_once 'model/Order.php';

// массив метаданных
$meta = array();

//Обработка ajax запросов
if(isset($_GET['ajax'])){
    $view = $_GET['ajax'];
    //Подключаем вид
    require_once VIEW.'ajax/'.$view.'.php';
    die();
}

//===Авторизация===//
if(isset($_GET['auth'])){
    if($_GET['auth'] == 'logout'){
        require_once VIEW.'auth/logout.php';
    }
    else if($_GET['auth'] == 'activation'){
        require_once VIEW.'auth/activation.php';
    }
    else if($_GET['auth'] == 'native'){
        require_once VIEW.'auth/auth_native.php';
    }
    else{
        require_once VIEW.'auth/login.php';
    }
}
else if(isset($_GET['provider'])){
    require_once VIEW.'auth/login.php';
}
//===Авторизация===//
else{
    //Переключение видов
    if(isset($_GET['view'])){
        $view = $_GET['view'];
    }
    else{
        $view = 'main';
    }
    
    switch ($view) {
        case 'main':
            $meta['title'] = 'Lego';
            $meta['description'] = 'Lego';
            $meta['keywords'] = 'lego';
            break;
        
        case 'product':
            if(!isset($_GET['id'])){
                die('Страница не найдена');
            }
            $id=$_GET['id'];
            $product = new Product();
            $product->getFomDb(array('id'=>$id), $conn);
            $category = new Category();
            $category->getFomDb(array('id'=>$product->category), $conn);

            $meta['title'] = "Конструктор Lego $product->title LEGO® $category->title $product->articul";
            $meta['description'] = "Купить Конструктор $product->title LEGO® $category->title $product->articul доступная цена, доставка в Киев, Харьков, Днепропетровск, Одесса, Львов";
            $meta['keywords'] = "Конструктор $product->title LEGO® $category->title $product->articul";
            break;
        default :
            $meta['title'] = 'Lego';
            $meta['description'] = 'Lego';
            $meta['keywords'] = 'Lego';
            break;
    }
    
    //Подключаем вид
    require_once VIEW.'index.php';
}
