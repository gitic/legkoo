<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Подключаем модель
require_once MODEL;

// подключение библиотеки функций
require_once 'functions/functions.php';
require_once 'functions/classSimpleImage.php';

//require_once 'model/autoload.php';
//require_once 'model/User.php';
//require_once 'model/Ingredient.php';
//require_once 'model/DishCategory.php';
//require_once 'model/Site.php';
//require_once 'model/Recipe.php';
//require_once 'model/InfoPage.php';
//require_once 'model/Article.php';

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
            $meta['title'] = 'Ricettio.com - пошаговые рецепты с фотографиями';
            $meta['description'] = 'Ricettio.com - пошаговые рецепты с фотографиями. Приготовление еды дома с удовольствием!';
            $meta['keywords'] = 'Ricettio.com - пошаговые рецепты с фотографиями. Приготовление еды дома с удовольствием!';
            break;
    }
    
    //Подключаем вид
    require_once VIEW.'index.php';
}
