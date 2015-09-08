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
require_once 'model/Label.php';
require_once 'model/Client.php';

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
            $meta['title'] = 'Интернет-магазин LEGO (ЛЕГО): купить LEGO конструкторы и игрушки ЛЕГО с доставкой по Киеву и Украине: Legkoo';
            $meta['description'] = 'Купить ЛЕГО в интернет-магазине. Цены, описания, фото, каталог конструкторов ЛЕГО и игрушек LEGO в официальном магазине Legkoo. Доставка и розничные магазины ЛЕГО по Украине';
            $meta['keywords'] = ' лего заказать купить продажа каталог конструктор игрушки доставка lego интернет магазин';
            break;
              
        case 'category':
            $meta['title'] = "Конструкторы Lego";
            $meta['description'] = "";
            $meta['keywords'] = "";
            break;
        
        case 'category_page':
            $id=$_GET['id'];
            $category = new Category();
            $category->getFomDb(array('id'=>$id), $conn);
            $meta['title'] = "Лего $category->title: купить конструктор LEGO® $category->title на Legkoo";
            $meta['description'] = "Купить набор Лего $category->title в интернет-магазине с доставкой по Украине. Конструктор LEGO® $category->title в наличии и под заказ";
            $meta['keywords'] = "Лего $category->title купить конструктор набор LEGO® $category->title цена недорого продажа интернет-магазин";
            break;
        
        case 'product':
            $id=$_GET['id'];
            $product = new Product();
            $product->getFomDb(array('id'=>$id), $conn);
            $category = new Category();
            $category->getFomDb(array('id'=>$product->category), $conn);

            $meta['title'] = "Конструктор $product->title LEGO® $category->title $product->articul";
            $meta['description'] = "Купить Конструктор $product->title LEGO® $category->title $product->articul доступная цена, доставка в Киев, Харьков, Днепропетровск, Одесса, Львов";
            $meta['keywords'] = "Конструктор $product->title LEGO® $category->title $product->articul";
            break;
        
        case 'info_page':
            $id=$_GET['id'];
            $infopage = new Infopage();
            $infopage->getFomDb(array('id'=>$id), $conn);
            $meta['title'] = "$infopage->title";
            $meta['description'] = "";
            $meta['keywords'] = "";
            break;
        
        case 'cart':
            $meta['title'] = "Корзина";
            $meta['description'] = "";
            $meta['keywords'] = "";
            break;
        
        case 'search':
            $meta['title'] = "Поиск";
            $meta['description'] = "";
            $meta['keywords'] = "";
            break;
        
        case 'article_page':
            $id = $_GET['id'];
            $article = new Article();
            $article->getFomDb(array('id'=>$id), $conn);
            $meta['title'] = "$article->title";
            $meta['description'] = "$article->preview";
            $meta['keywords'] = "$article->title";
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
