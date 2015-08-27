<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Запросы в Controller
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
    <div id="product" itemscope itemtype="http://schema.org/Product">
        <h1 itemprop="name"><?=$product->title?> <span>артикул: <?=$product->articul?></span></h1>
        <div class="productGallery">
            <?php $gArr = explode(',', $product->gallery);?>
            <img src="<?=$gArr[1]?>" class="bigFoto" itemprop="image" alt="<?=$product->title?>" title="<?=$product->title?>"/>
            <?php
                
                for($i=1;$i<count($gArr);$i++):
            ?>
                <span><img src="<?=$gArr[$i]?>" alt="<?=$product->title?>" title="<?=$product->title?>"/></span>
            <?php endfor;?>
                
        </div>
        <div class="productData">
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                <div class="block">
                    <?php
                        $till = '+';
                        if($product->age_to != 0){$till = '-'.$product->age_to;}
                    ?>
                    <p>Возраст: <strong><?=$product->age_from.$till?></strong></p>
                    <p>Количество деталей: <strong><?=$product->elements?></strong></p>
                    <?php if($product->size != ''):?>
                    <p>Размеры (Д*Ш*В): <strong><?=$product->size?></strong></p>
                    <?php endif;?>
                </div>
                <div class="block">
                    <div class="productPrice">
                        <?=$product->price?> <span>грн</span>
                        <meta itemprop="price" content="<?=$product->price?>">
                        <meta itemprop="priceCurrency" content="UAH">
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
                        <input type="hidden" value="<?=$product->title?>">
                        <span>В КОРЗИНУ</span>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="block">
                <div class="productAbout" itemprop="description">
                    <p>Описание:</p> <?=$product->description?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <input class='productID' type="hidden" hidden value="<?=$product->id?>">
    </div>
</div>