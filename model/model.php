<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printProductCart($product){?>
    <div class="productPreview">
		<div style="position:absolute;right:0;top:0;">
			
		</div>
       
        <div class="labels">
            <?php if($product->price >= 1000 AND $product->old_price == 0):?>
                <span class="label free" title="Бесплатная доставка">Бесплатная доставка</span><br/>
            <?php endif;?>
            <?php if($product->labels != ''):?>
                <?php
                    $labels = explode(',', $product->labels);
                    if($product->old_price != 0){
                        if(!in_array("Акция+sale", $labels)){
                            $labels[] = "Акция+sale";
                        }
                    }
                    foreach ($labels as $label):
                        $label = explode('+', $label);
                ?>
                <span class="label <?=$label[1]?>" title="<?=$label[0]?>">
                    <?=$label[0]?>
                </span><br/>
                <?php endforeach;?>
            <?php elseif($product->old_price != 0):?>
                <span class="label sale" title="Акция">Акция</span><br/>
            <?php endif;?> 
        </div>
        <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">
            <?php $gArr = explode(',', $product->gallery);?>
            <img src="<?=$gArr[1]?>" class="big" alt="<?=$product->title?>" title="<?=$product->title?>"/>
            
            <!--<img src="<?=$product->photo?>" class="big" alt="<?=$product->title?>" title="<?=$product->title?>"/>-->
        </a>
        <div class="previewTitle">
            <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">LEGO <?=$product->category?> <?=$product->title?> <?=$product->articul?></a>
            <?php
                        $till = '+';
                        if($product->age_to != 0){$till = '-'.$product->age_to;}
                    ?>
                    <p>Возраст: <?=$product->age_from.$till?></p>
        </div>
        <div class="previewPrice">
            <?php if($product->old_price != 0):?>
                <p><span style='text-decoration:line-through;color:gray;font-size: 13px;line-height:12px'><?=$product->old_price?> грн</span></p>
                <p style="color:#E30613;line-height:24px;font-weight:500;"><?=$product->price?> <span style="color:#E30613">грн</span></p>
            <?php else:?>
                <?=$product->price?> <span>грн</span>
            <?php endif;?>
        </div>
        <div class="previewBtn <?=$product->id?>">
            <?php 
                $addClass = '';
                $text = 'В КОРЗИНУ';
                if($product->quantity <=0){
                    $addClass = "class='disabled'";
                    $text = 'ОЖИДАЕТСЯ';
                }
            ?>
            <span <?=$addClass?> onclick="yaCounter32188239.reachGoal('ya-btn-two'); return true;">
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

<?php
function printProductWithLogo($product){?>
    <div class="productPreview">
		<div style="position:absolute;right:0;top:0;">
			
		</div>
       
        <div class="labels">
            <?php if($product->price >= 1000 AND $product->old_price == 0):?>
                <span class="label free" title="Бесплатная доставка">Бесплатная доставка</span><br/>
            <?php endif;?>
            <?php if($product->labels != ''):?>
                <?php
                    $labels = explode(',', $product->labels);
                    if($product->old_price != 0){
                        if(!in_array("Акция+sale", $labels)){
                            $labels[] = "Акция+sale";
                        }
                    }
                    foreach ($labels as $label):
                        $label = explode('+', $label);
                ?>
                <span class="label <?=$label[1]?>" title="<?=$label[0]?>">
                    <?=$label[0]?>
                </span><br/>
                <?php endforeach;?>
            <?php elseif($product->old_price != 0):?>
                <span class="label sale" title="Акция">Акция</span><br/>
            <?php endif;?> 
        </div>
        <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">
            <?php $gArr = explode(',', $product->gallery);?>
            <img src="<?=$gArr[1]?>" class="big" alt="<?=$product->title?>" title="<?=$product->title?>"/>
            
            <!--<img src="<?=$product->photo?>" class="big" alt="<?=$product->title?>" title="<?=$product->title?>"/>-->
        </a>
        <div class="previewTitle">
            <!--<img width="50px" src="<?=$product->cat_logo?>"/>-->
            <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">LEGO <?=$product->category?> <?=$product->title?> <?=$product->articul?></a>
            <?php
                        $till = '+';
                        if($product->age_to != 0){$till = '-'.$product->age_to;}
                    ?>
                    <p>Возраст: <?=$product->age_from.$till?></p>
        </div>
        <div class="previewPrice">
            <?php if($product->old_price != 0):?>
                <p><span style='text-decoration:line-through;color:gray;font-size: 13px;line-height:12px'><?=$product->old_price?> грн</span></p>
                <p style="color:#E30613;line-height:24px;font-weight:500;"><?=$product->price?> <span style="color:#E30613">грн</span></p>
            <?php else:?>
                <?=$product->price?> <span>грн</span>
            <?php endif;?>
        </div>
        <div class="previewBtn <?=$product->id?>">
            <?php 
                $addClass = '';
                $text = 'В КОРЗИНУ';
                if($product->quantity <=0){
                    $addClass = "class='disabled'";
                    $text = 'ОЖИДАЕТСЯ';
                }
            ?>
            <span <?=$addClass?> onclick="yaCounter32188239.reachGoal('ya-btn-two'); return true;">
                <input type="hidden" value="<?=$product->title?>">
                <?=$text?>
            </span>
        </div>
        <div class="clear"></div>
    </div>
<?php }