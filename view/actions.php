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
                $result = $conn->query("SELECT * FROM products WHERE visible='1' AND old_price != '0' ORDER BY title ASC");
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
    </div>
</div>