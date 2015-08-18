<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(!isset($_GET['id'])){
    die('Страница не найдена');
}
$id=$_GET['id'];
$product = new Product();
$product->getFomDb(array('id'=>$id), $conn);
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="#">главная</a> / каталог
    </div>
</div>

<div id="content">
    <div id="product">
        <div class="productGallery">
            <img src="<?=$product->photo?>" class="big"/>
            <?php
                $gArr = explode(',', $product->gallery);
                for($i=1;$i<count($gArr);$i++):
            ?>
                <a href="#"><img src="<?=$gArr[$i]?>"/></a>
            <?php endfor;?>
        </div>
        <div class="productData">
            <h1><?=$product->title?> <span>артикул: <?=$product->articul?></span></h1>
            <div class="block">
                <p>Возраст: <strong><?=$product->age_from?>-<?=$product->age_to?></strong></p>
                <p>Количество деталей: <strong><?=$product->elements?></strong></p>
                <p>Размеры (Д*Ш*В): <strong><?=$product->size?></strong></p>
            </div>
            <div class="block">
                <div class="productPrice">
                    <?=$product->price?> <span>грн</span>
                </div>
            </div>
            <div class="block">
                <div class="productBuy">
                    Количество: <div class="numbers"><input value="1" type="text" />
                        <div class="increase">
                            <span>+</span>
                            <span>-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <div class="productAbout">
                    <?=$product->description?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>