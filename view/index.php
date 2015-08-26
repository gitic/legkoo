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
        <?php require_once 'blocks_site/head.php'; ?>
        <?php if($view == 'product'):?>
            <meta property="og:title" content="" />
            <meta property="og:type" content="product" />
            <meta property="og:url" content="" />
            <meta property="og:image" content="" />
            <meta property="og:site_name" content="" />
            <meta property="og:description" content=""/>
        <?php endif;?>
    </head>
    <body>
        
        <?php require_once VIEW.'blocks_site/header.php'; ?>
        
        <?php require_once $view.'.php';?>
              
        <?php require_once VIEW.'blocks_site/footer.php'; ?>
    </body>
</html>
