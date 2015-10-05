<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

function printProductCart($product){?>
    <div class="productPreview">
        <div class="productIcon">
            <?php if($product->video != ''):?>
            <i class="fa fa-video-camera" alt="Видео обзор набора" title="Видео обзор набора"></i>
            <?php endif;?>
            <?php if($product->instruction != ''):?>
            <i class="fa fa-file-text-o" alt="Можно скачать инструкцию по сборке" title="Можно скачать инструкцию по сборке"></i>
            <?php endif;?>
        </div>
        <?php if($product->labels != ''):?>
        <div class="labels">
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
        </div>
        <?php elseif($product->old_price != 0):?>
        <div class="labels"><span class="label sale" title="Акция">Акция</span><br/></div>
        <?php endif;?>
        <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>">
            <img src="<?=$product->photo?>" class="big"/>
        </a>
        <div class="previewTitle">
            <p><span>Арт. <?=$product->articul?></span>LEGO® <?=$product->category?></p>
            <div class="clear"></div>
            <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>"><?=$product->title?></a>
        </div>
        <div class="previewPrice">
            <?php if($product->old_price != 0):?>
                <p><span style='text-decoration:line-through;color:gray;font-size: 14px'><?=$product->old_price?> грн</span></p>
                <p style="color:red"><?=$product->price?> <span style="color:red">грн</span></p>
            <?php else:?>
                <?=$product->price?> <span>грн</span>
            <?php endif;?>
        </div>
        <div class="previewBtn <?=$product->id?>">
            <?php 
                $addClass = '';
                $text = 'КУПИТЬ';
                if($product->quantity <=0){
                    $addClass = "class='disabled'";
                    $text = 'ОЖИДАЕТСЯ';
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