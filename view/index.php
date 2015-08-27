<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$meta['title']?></title>
        <meta name="description" content="<?=$meta['description']?>">
        <meta name="keywords" content="<?=$meta['keywords']?>">	
        <?php if($view == 'product'):?>
            <meta property="og:title" content="LEGO <?=$product->title?> <?=$product->articul?>" />
            <meta property="og:type" content="product" />
            <meta property="og:url" content="<?=request_url()?>" />
            <meta property="og:image" content="<?=PATH?>/<?=$product->photo?>" />
            <meta property="og:site_name" content="<?=TITLE?>" />
            <meta property="og:description" content="<?= mb_substr(strip_tags($product->description), 0, 150, 'UTF-8').'...'?>"/>
        <?php endif;?>
        <?php require_once 'blocks_site/head.php'; ?>
    </head>
    <body>
        
        <?php require_once VIEW.'blocks_site/header.php'; ?>
        
        <?php require_once $view.'.php';?>
              
        <?php require_once VIEW.'blocks_site/footer.php'; ?>
    </body>
</html>
