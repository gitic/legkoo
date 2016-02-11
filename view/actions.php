<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / акции
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Акционные товары</h1>
        <div id="catPreview">            
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.old_price != '0' AND t1.quantity>0 ORDER BY title ASC";
//                $result = $conn->query("SELECT * FROM products WHERE visible='1' AND old_price != '0' AND quantity>0 ORDER BY title ASC");
                $result = $conn->query($sql);
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
    </div>
</div>