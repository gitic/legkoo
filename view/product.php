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
        <h1 itemprop="name">LEGO <?=$category->title?> <?=$product->title?> <?=$product->articul?></h1>
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
                <div class="block gray">
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
                    <div class="block gray">
                        <div class="labels product"><span class="label pr sale" title="Акция">Акция</span></div>
                    </div>
                <?php endif;?>
                <div class="block gray">
                    <div class="productPrice">
					
                        <?php if($product->old_price != 0):?>
                            <span style='text-decoration:line-through;color:gray;font-size:14px;'><?=$product->old_price?> грн</span>
                            <span style="color:#E30613;font-weight:500;font-size:46px;"><?=$product->price?> <span style="color:#E30613">грн</span></span>
                        <?php else:?>
                            <?=$product->price?> <span>грн</span>
                        <?php endif;?>
                        
                        <meta itemprop="price" content="<?=$product->price?>">
                        <meta itemprop="priceCurrency" content="UAH">
						
						<em>*при заказе от <strong>1000 грн</strong><br/> бесплатная доставка</em>
                    </div>
                </div>
                <div class="block btnbuy gray">
                    <div class="productBuy">
                        <div class="numbers"><input value="1" type="text" />
                            <div class="increase">
                                <span class='plusBtn'>+</span>
                                <span class='minusBtn'>-</span>
                            </div>
                        </div>
                    </div>
                    <div class="buyBtnSet">
                        <div id="ya-btn-one" class="btn buy" onclick="yaCounter32188239.reachGoal('ya-btn-one'); return true;">
                            <?php 
                                $addClass = '';
                                $text = '<i class="fa fa-shopping-cart" aria-hidden="true"></i> В КОРЗИНУ';
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
                </div><div class="shareBtn">


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
<div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="6" data-mode="share" data-like-text-enable="false" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.wh.vb." data-pid="1409452" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons" ></div>
                </div>
            
                <div class="block">
                    <?php
                        $till = '+';
                        if($product->age_to != 0){$till = '-'.$product->age_to;}
                    ?>
                    <p>Возраст: <strong><?=$product->age_from.$till?></strong></p>
					<?php if($product->elements != '0'):?>
                    <p>Количество деталей: <strong><?=$product->elements?></strong></p>
                    <?php endif;?>
                    <?php if($product->size != ''):?>
                    <p>Размеры (Д*Ш*В): <strong><?=$product->size?></strong></p>
                    <?php endif;?>
                    <?php if($product->figurka != 0):?>
                    <p>Минифигурок: <strong><?=$product->figurka?></strong></p>
                    <?php endif;?>
                </div>
                <div class="block tabs">
                    <ul>
                        <?php if($product->video != ''):?>
                        <li>Видео</li>
                        <?php endif;?>
                        <li>Описание</li>
                        <li>Оплата и доставка</li>
                        <li class="invisibleTab">Инструкция</li>
                    </ul>
                    <div>
                        <?php if($product->video != ''):?>
                        <div id="videoTab" class="videoTab">
                            <?php if($product->video != ''):?>
                            <iframe src="<?=$product->video?>" frameborder="0" allowfullscreen></iframe>
                            <em>*видео взято с сайта YouTube.com</em>
                            <?php else:?>
                            Видео отсутствует
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                        <div class="productAbout" itemprop="description">
                            <?=$product->description?>
                        </div>
                        <div class="deliveryTab">
                            <p><strong>Доставка: </strong></p>
                            <p><em>Условия доставки по всей Украине:</em></p>
                            <p>
                            - Доставка в Ваш регион перевозчиком «Новая почта» - от 25 грн<br/>
                            - Доставка на ближайший к Вам склад «Новой почтой» при заказе от 1000 грн - Бесплатно (Обязательная предоплата!)</p>
                            <p><em>Условия доставки по Днепру:</em></p>
                            <p>- Самовывоз: просп. Карла Маркса 67-Д ТЦ «Гранд Плаза»<br/> 
- Доставка на ближайший к Вам склад «Новой почтой» - от 25 грн<br/> 
- Доставка на ближайший к Вам склад «Новой почтой» при заказе от 1000 грн - Бесплатно (Обязательная предоплата!)<br/>
                            - Внимание: если Вы оплачиваете Заказ при получении - Наложенный платёж «Новой почтой» оплачиваете Вы - 2% от стоимости заказа + 20 гривен за оформление.</p>
                            <p style="text-align:right;"><a href="https://novaposhta.ua/ru/delivery" target="_blank" style="font-size:14px;font-weight:500;"><i class="fa fa-calculator"></i> Рассчитать стоимость доставки</a></p>
                            <p><strong>Оплата: </strong></p>
                            <p>- Кредитной картой<br/>
                            - Приват24<br/>
                            - При доставке в отделение Новой Почты</p>
                        </div>
                        <div class="invisibleTab" style="text-align:center;">
                            <?php if($product->instruction != ''):?>
                            <i class="fa fa-file-pdf-o"></i> <a href="<?=$product->instruction?>" target="_blank">Смотреть инструкцию</a>
                            <em>*некоторые инструкции могут превышать 10Мб (!)</em>
                            <?php else:?>
                            Инструкция отсутствует
                            <?php endif;?>
                        </div>
                    </div>  
                    <script>
                    $(document).ready(function(){
                        $(".tabs").lightTabs();
                    });</script>
                </div> 
        </div>
        <div class="clear"></div>
        
        <div class="comments">
        <h3>Отзыв о товаре</h3>
        <div id="hypercomments_widget"></div>
            <script type="text/javascript">
            _hcwp = window._hcwp || [];
            _hcwp.push({widget:"Stream", widget_id: 68368});
            (function() {
            if("HC_LOAD_INIT" in window)return;
            HC_LOAD_INIT = true;
            var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
            var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
            hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/68368/"+lang+"/widget.js";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hcc, s.nextSibling);
            })();
            </script>
        </div>
         <div class="more-products">
            <?php
            $arrProducts = array();
            $checkArr = array();
            $fromPrice = $product->price - 150;
            $toPrice = $product->price + 150;
            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
                  ."WHERE t1.visible='1' AND t1.quantity>0 AND t1.category='$product->category' AND (t1.price>=$fromPrice AND t1.price<=$toPrice) AND t1.id!=$product->id";
            $result = $conn->query($sql);
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
        <div class="guarant">
            <h3>Почему мы?</h3>
            <div class="block">
                <img src="<?=VIEW?>images/guarant1.png"/> 
                <p>У нас есть офлайновый магазин в Днепре ТЦ «Гранд Плаза»</p>
            </div>
            <div class="block">
                <img src="<?=VIEW?>images/guarant2.png"/>
                <p>Мы уже 3 года в Украине</p>
            </div>
            <div class="block">
                <img src="<?=VIEW?>images/guarant3.png"/>
                <p>Доставляем по всей Украине перевозчиком «Новая почта»</p>
            </div>
            <div class="block">
                <img src="<?=VIEW?>images/guarant4.png"/>
                <p>Работаем напрямую с представительством LEGO в Украине</p>
            </div>
            <div class="block">
                <img src="<?=VIEW?>images/guarant5.png"/>
                <p>У нас есть эксклюзивные коллекции</p>
            </div>
            <div class="clear"></div>
        </div>
        
        
       
        <input class='productID' type="hidden" hidden value="<?=$id?>">
    </div>
</div>
