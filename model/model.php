<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printProductCart($product){?>
    <div class="productPreview">
        <a href="#">
            <img src="<?=$product->photo?>" class="big"/>
        </a>
        <div class="previewTitle">
            <p><span>Арт. <?=$product->articul?></span>LEGO <?=$product->category?></p>
            <div class="clear"></div>
            <a href="#"><?=$product->title?></a>
        </div>
        <div class="previewPrice">
            <?=$product->price?> <span>грн</span>
        </div>
        <div class="previewBtn">
            <span>
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