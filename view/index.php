<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<!DOCTYPE html>
<html lang="ru" xmlns:og="http://ogp.me/ns#">
    <head>
        <meta charset="UTF-8">
        <title><?=$meta['title']?></title>
        <meta name="description" content="<?=$meta['description']?>">
        <meta name="keywords" content="<?=$meta['keywords']?>">	
        <meta property="fb:admins" content="100000219033422" />
        <?php if($view == 'product'):?>
            <meta property="og:title" content="Конструктор LEGO <?=$product->articul?> <?=$product->title?>" />
            <meta property="og:type" content="product" />
            <meta property="og:url" content="<?=request_url()?>" />
            <meta property="og:image" content="<?=PATH?><?=$product->photo?>" />
            <meta property="image" content="<?=PATH?><?=$product->photo?>" />
            <meta property="og:site_name" content="<?=TITLE?>" />
            <meta property="og:description" content="<?= mb_substr(strip_tags($product->description), 0, 150, 'UTF-8').'...'?>"/>
        <?php endif;?>
        <?php if($view == 'category_page'):?>
            <meta property="og:title" content="Конструкторы Лего <?=$category->title?>" />
            <meta property="og:type" content="product" />
            <meta property="og:url" content="<?=request_url()?>" />
            <meta property="og:image" content="<?=PATH?><?=$category->photo?>" />
            <meta property="image" content="<?=PATH?><?=$category->photo?>" />
            <meta property="og:site_name" content="<?=TITLE?>" />
        <?php endif;?>
        <?php if($view == 'info_page' && $id=7):?>
            <meta property="og:title" content="<?=$infopage->title?> от магазина Legkoo.com.ua" />
            <meta property="og:description" content="Я получил(а) скидку 3% на конструкторы Lego в магазине Legkoo.com.ua! Успей и ты!"/>
            <meta property="og:url" content="<?=PATH?>" />
            <meta property="url" content="<?=PATH?>" />
            <meta property="og:type" content="article" />  
             <meta property="og:image" content="<?=PATH?>/<?=VIEW?>images/likeaction.jpg" />
             <meta property="image" content="<?=PATH?>/<?=VIEW?>images/likeaction.jpg" />
        <?php endif;?>
        <?php require_once 'blocks_site/head.php'; ?>
    </head>
    <body>
        <?php if(file_exists('controller/'.$view.'.php')) {require_once 'controller/'.$view.'.php';}?>
        
        <?php require_once VIEW.'blocks_site/header.php'; ?>
        
        <?php require_once VIEW.'blocks_site/ask_form.php'; ?>
        
        <?php require_once $view.'.php';?>
              
        <?php require_once VIEW.'blocks_site/footer.php'; ?>
    </body>
</html>
