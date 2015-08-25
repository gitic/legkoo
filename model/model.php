<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printProductCart($product){?>
    <div class="productPreview">
        <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">
            <img src="<?=$product->photo?>" class="big"/>
        </a>
        <div class="previewTitle">
            <p><span>Арт. <?=$product->articul?></span>LEGO <?=$product->category?></p>
            <div class="clear"></div>
            <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>"><?=$product->title?></a>
        </div>
        <div class="previewPrice">
            <?=$product->price?> <span>грн</span>
        </div>
        <div class="previewBtn <?=$product->id?>">
            <span>
                <input type="hidden" value="<?=$product->title?>">
                В КОРЗИНУ
            </span>
        </div>
        <div class="clear"></div>
    </div>
<?php }

function printCategoryCart($category){?>
    <a href="category-<?=$category->id?>-lego-<?=$category->translit?>" class="catPreviewBlock">
        <img src="<?=$category->photo?>"/>
    </a>
<?php }?>