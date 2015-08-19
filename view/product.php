<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(!isset($_GET['id'])){
    die('Страница не найдена');
}
$id=$_GET['id'];
$product = new Product();
$product->getFomDb(array('id'=>$id), $conn);
$category = new Category();
$category->getFomDb(array('id'=>$product->category), $conn);
?>
<script src="<?=VIEW?>js/productJs.js"></script>
<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="catalog">каталог</a> / 
        <a href="category-<?=$product->category?>-lego-<?=$category->translit?>"><?=$category->title?></a> / 
        <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>"><?=$product->title?></a>
    </div>
</div>

<div id="content">
    <div id="product">
        <h1><?=$product->title?> <span>артикул: <?=$product->articul?></span></h1>
        <div class="productGallery">
            <?php $gArr = explode(',', $product->gallery);?>
            <img src="<?=$gArr[1]?>" class="bigFoto"/>
            <?php
                
                for($i=1;$i<count($gArr);$i++):
            ?>
                <span><img src="<?=$gArr[$i]?>"/></span>
            <?php endfor;?>
                
        </div>
        <div class="productData">
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
                            <span class='plusBtn'>+</span>
                            <span class='minusBtn'>-</span>
                        </div>
                    </div>
                </div>
                <div class="btn buy">
                    <span>КУПИТЬ</span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="block">
                <div class="productAbout">
                    <p>Описание:</p> <?=$product->description?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>