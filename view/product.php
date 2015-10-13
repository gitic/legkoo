<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Запросы в Controller
$numView = $product->views;
$numView++;
Product::update(array('views'=>$numView), array('id'=>$id), $conn);
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
        <h1 itemprop="name">Конструктор <?=$product->title?> LEGO® <?=$category->title?><span>артикул: <?=$product->articul?></span></h1>
        <div class="productGallery">
            <?php $gArr = explode(',', $product->gallery);?>
            <img data-zoom-image="<?=$gArr[1]?>" src="<?=$gArr[1]?>" class="bigFoto" itemprop="image" alt="<?=$product->title?>" title="<?=$product->title?>"/>
            <?php
                for($i=1;$i<count($gArr);$i++):
            ?>
                <span><img src="<?=$gArr[$i]?>" alt="<?=$product->title?>" title="<?=$product->title?>"/></span>
            <?php endfor;?>
                
        </div>
        <div class="productData" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            
                <?php if($product->labels != ''):?>
                <div class="block">
                    <div class="labels product">
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
                        <span class="label pr <?=$label[1]?>" title="<?=$label[0]?>">
                            <?=$label[0]?>
                        </span>
                        <?php endforeach;?>
                    </div>
                </div>
                <?php elseif($product->old_price != 0):?>
                    <div class="block">
                        <div class="labels product"><span class="label pr sale" title="Акция">Акция</span></div>
                    </div>
                <?php endif;?>
                <div class="block">
                    <div class="productPrice">
                        <?php if($product->old_price != 0):?>
                            <span style='text-decoration:line-through;color:gray;font-size:14px;'><?=$product->old_price?> грн</span>
                            <span style="color:red;font-weight:bold;font-size:46px;"><?=$product->price?> <span style="color:red">грн</span></span>
                        <?php else:?>
                            <?=$product->price?> <span>грн</span>
                        <?php endif;?>
                        <?php if($product->old_price == 0):?>
                            <div style="font-size:14px;">
                            <a href="http://legkoo.com.ua/info-7" target="_blank" class="discInfo">хочу скидку!</a></div>
                        <?php endif;?>
                        
                        <meta itemprop="price" content="<?=$product->price?>">
                        <meta itemprop="priceCurrency" content="UAH">
                    </div>
                </div>
                <div class="block btnbuy">
                    <div class="productBuy">
                        Количество: <div class="numbers"><input value="1" type="text" />
                            <div class="increase">
                                <span class='plusBtn'>+</span>
                                <span class='minusBtn'>-</span>
                            </div>
                        </div>
                    </div>
                    <div class="buyBtnSet">
                        <div class="btn buy">
                            <?php 
                                $addClass = '';
                                $text = '<i class="fa fa-hand-pointer-o fa-rotate-90"></i> КУПИТЬ';
                                if($product->quantity <=0){
                                    $addClass = "class='disabled'";
                                    $text = 'ОЖИДАЕТСЯ';
                                }
                            ?>
                            <input type="hidden" value="<?=$product->title?>">
                            <span <?=$addClass?>><?=$text?></span>
                        </div>
                        <?php if($product->quantity > 0):?>
                        <div style="cursor:pointer;" class="oneClickBtn">
                            <input type="hidden" value="<?=$product->title?>">
                            <span >купить в 1 клик</span>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="clear"></div>
                </div>
            
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
            <div class="shareBtn">
        
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="false" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1409452" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons" ></div>
    </div>
                <div class="block tabs">
                    <ul>
                        <li>Описание</li>
                        <li>Видео</li>
                        <li class="invisibleTab">Инструкция</li>
                        <li>Оплата и доставка</li>
                    </ul>
                    <div>
                        <div class="productAbout" itemprop="description">
                            <?=$product->description?>
                        </div>
                        <div id="videoTab" class="videoTab">
                            <?php if($product->video != ''):?>
                            <iframe src="<?=$product->video?>" frameborder="0" allowfullscreen></iframe>
                            <em>*видео взято с сайта YouTube.com</em>
                            <?php else:?>
                            Видео отсутствует
                            <?php endif;?>
                        </div>
                        <div class="invisibleTab" style="text-align:center;">
                            <?php if($product->instruction != ''):?>
                            <i class="fa fa-file-pdf-o"></i> <a href="<?=$product->instruction?>" target="_blank">Смотреть инструкцию</a>
                            <em>*некоторые инструкции могут превышать 10Мб (!)</em>
                            <?php else:?>
                            Инструкция отсутствует
                            <?php endif;?>
                        </div>
                        <div class="deliveryTab">
                            <p><strong>Доставка: </strong></p>
                            <p>Условия доставки по всей Украине:</p>
                            <p>- Бесплатная доставка на склад Новой почты при заказе от 1000 грн. <br/>
                            - Адресная доставка курьером Новой почты - 40 грн. </p>
                            <p>Условия доставки по Днепропетровску:</p>
                            <p>- Самовывоз: просп. Карла Маркса 67-Д ТЦ «Гранд Плаза»<br/> 
                            - Адресная доставка нашим курьером при заказе от 1000 - бесплатно! </p>
                            <p><strong>Оплата: </strong></p>
                            <p>- Кредитной картой<br/>
                            - Приват24<br/>
                            - При доставке в отделение Новой Почты</p>
                        </div>
                    </div>  
                    <script>
                    $(document).ready(function(){
                        $(".tabs").lightTabs();
                    });</script>
                </div> 
        </div>
        <div class="clear"></div>
        <div class="more-products">
            <?php
            $arrProducts = array();
            $checkArr = array();
            $fromPrice = $product->price - 150;
            $toPrice = $product->price + 150;
            $result = $conn->query("SELECT * FROM products WHERE category='$product->category' AND (price>=$fromPrice AND price<=$toPrice) AND id!=$product->id");
            while($record = $result->fetch_object()){
                $arrProducts[] = $record;
            }
            if(count($arrProducts)>0){
                echo '<h3>Похожие товары</h3>';
            }
            if(count($arrProducts)>3){
                $randArr = array();
                while (count($randArr)!=3){
                    $rand = rand(0, count($arrProducts)-1);
                    if(!in_array($rand, $checkArr)){
                        $randArr[] = $arrProducts[$rand];
                        $checkArr[] = $rand;
                    }
                }
                foreach ($randArr as $product) {
                    printProductCart($product);
                }
            }
            else{
                foreach ($arrProducts as $product) {
                    printProductCart($product);
                }
            }
            ?>
        </div>
        <input class='productID' type="hidden" hidden value="<?=$id?>">
    </div>
</div>
