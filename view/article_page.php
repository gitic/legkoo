<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Запросы в контроллере
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="#">новости и акции</a> / <?=$article->title?>
    </div>
</div>

<div id="content" class="news">
    <div id="page">
        <img src="<?=$article->photo?>" class="newsImage"/>
        <h1><?=$article->title?></h1>
        <div class="text">
            <p><?=$article->text?></p>
        </div>
        <div class="newsProduct">
            <?php
                if($article->products !== ''){
                    $sql = "SELECT * FROM products WHERE visible='1' AND id IN ($article->products)";
                    $result = $conn->query($sql);
                    while ($product = $result->fetch_object()){
                        printProductCart($product);
                    }
                }
            ?>
        </div>
    </div>
</div>