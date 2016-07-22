<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / Карта сайта
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Карта сайта</h1>
        <div>            
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.quantity>0 ORDER BY title ASC";
                $result = $conn->query($sql);
                $i=0;
                while ($record = $result->fetch_object()){
                    $i++;
                    $product = new Product();
                    $product = $record;
                echo $i;
            ?>
            <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">LEGO <?=$product->category?> <?=$product->title?> <?=$product->articul?></a><br>
            <?php
                }
            ?>
        </div>
    </div>
</div>