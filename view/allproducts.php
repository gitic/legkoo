<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//запросы в Controller
$result = $conn->query("SELECT COUNT(*) FROM products WHERE visible='1'");
$total_rows = $result->fetch_array()[0];
?>

<div id="content">
    <div id="main">
        <h1>Страницы сайта</h1>
        
        <div id="catProduct">
            <?php
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
        
        <div class="catAbout">
            <?=$category->description?>
        </div>
    </div>
</div>
