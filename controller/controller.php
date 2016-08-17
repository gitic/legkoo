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
            $meta['title'] = 'Интернет-магазин конструкторов LEGO (ЛЕГО): Legkoo.com.ua';
            $meta['description'] = 'Купить ЛЕГО в интернет-магазине. Цены, описания, фото, каталог конструкторов ЛЕГО и игрушек LEGO в сертифицированном магазине Legkoo';
            $meta['keywords'] = ' лего заказать купить продажа каталог конструктор игрушки доставка lego интернет магазин';
            break;
              
        case 'category':
            $meta['title'] = "Конструкторы Lego";
            $meta['description'] = "Полный каталог конструкторов LEGO (ЛЕГО), новинки 2016 года. Конструкторы купить с доставкой по всей Украине";
            $meta['keywords'] = "";
            break;
        
        case 'category_page':
            $id=$_GET['id'];
            $category = new Category();
            $category->getFomDb(array('id'=>$id), $conn);
            $meta['title'] = "Конструкторы Лего $category->title";
            $meta['description'] = "Купить набор Лего $category->title в интернет-магазине с доставкой по Украине. Конструктор LEGO® $category->title в наличии и под заказ";
            $meta['keywords'] = "Лего $category->title купить конструктор набор LEGO® $category->title цена недорого продажа интернет-магазин";
            break;
        
        case 'product':
            $id=$_GET['id'];
            $product = new Product();
            $product->getFomDb(array('id'=>$id), $conn);
            $category = new Category();
            $category->getFomDb(array('id'=>$product->category), $conn);

            $meta['title'] = "Конструктор LEGO $category->title $product->title $product->articul";
            $meta['description'] = "Купить Конструктор LEGO $category->title $product->title $product->articul доступная цена, доставка и самовывоз: описание, видео, обзор, инструкция";
            $meta['keywords'] = "Конструктор LEGO $category->title $product->title $product->articul";
            break;
        
        case 'info_page':
            $id=$_GET['id'];
            if($id == 7){
                $infopage = new Infopage();
                $infopage->getFomDb(array('id'=>$id), $conn);
                $meta['title'] = "$infopage->title от магазина Legkoo.com.ua";
                $meta['description'] = "Я получил(а) скидку 3% на конструкторы Lego в магазине Legkoo.com.ua! Успей и ты!";
                $meta['keywords'] = "Я получил(а) скидку 3% на конструкторы Lego в магазине Legkoo.com.ua! Успей и ты!";
                

            }
            else{
                $infopage = new Infopage();
                $infopage->getFomDb(array('id'=>$id), $conn);
                $meta['title'] = "$infopage->title";
                $meta['description'] = "";
                $meta['keywords'] = "";
            }
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
        
        case 'actions':
            $meta['title'] = "Акционные товары в магазине Legkoo.com.ua";
            $meta['description'] = "";
            $meta['keywords'] = "";
            break;
        
        case 'new_products':
            $meta['title'] = "Новые товары в магазине Legkoo.com.ua";
            $meta['description'] = "Новинки 2016 года конструкторов Лего";
            $meta['keywords'] = "";
            break;
        
        case 'sitemap':
            $meta['title'] = "Карта сайта";
            $meta['description'] = "";
            $meta['keywords'] = "";
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
