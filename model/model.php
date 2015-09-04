<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printProductCart($product){?>
    <div class="productPreview">
        <div class="labels">
            <?php
                $labels = explode(',', $product->labels);
                foreach ($labels as $label):
                    $label = explode('+', $label);
            ?>
            <span class="label <?=$label[1]?>" title="<?=$label[0]?>">
                <i class="fa fa-star"></i>
            </span>
            <?php endforeach;?>
        </div>
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
            <?php 
                $addClass = '';
                $text = 'В КОРЗИНУ';
                if($product->quantity <=0){
                    $addClass = "class='disabled'";
                    $text = 'НЕТ В НАЛИЧИИ';
                }
            ?>
            <span <?=$addClass?>>
                <input type="hidden" value="<?=$product->title?>">
                <?=$text?>
            </span>
        </div>
        <div class="clear"></div>
    </div>
<?php }

function printCategoryCart($category){?>
    <a href="category-<?=$category->id?>-lego-<?=$category->translit?>" class="catPreviewBlock">
        <img src="<?=$category->photo?>" alt="<?=$category->title?>" title="<?=$category->title?>"/>
    </a>
<?php }?>