<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
if(!isset($_GET['id'])){
    die('Страница не найдена');
}
$id=$_GET['id'];
$category = new Category();
$category->getFomDb(array('id'=>$id), $conn);
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / 
        <a href="catalog">каталог</a> / 
        <a href="category-<?=$category->id?>-lego-<?=$category->translit?>"><?=$category->title?></a>
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Купить конструктор LEGO® <?=$category->title?></h1>
        <div class="catLogo">
            <img src="<?=$category->logo?>"/>
        </div>
        <div id="catProduct">
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.category='$id' ORDER BY id DESC";
                $result = $conn->query($sql);
                echo $conn->error;
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
    </div>
</div>