<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<div id="content">
    <div id="main">
        <div class="slider">
            <div>
                <a href="category-25-lego-eksklyuziv">
                    <p>LEGO® Эксклюзив</p>
                    <img src="<?=VIEW?>images/exclusive.jpg" alt="LEGO® Эксклюзив"/>
                </a>
            </div>
            <div>
                <a href="product-651-lego-teoriya-bolshogo-vzryiva-21302">
                    <p>Теория Большого Взрыва 21302</p>
                    <img src="<?=VIEW?>images/bigbang.jpg" alt="Лего Теория Большого Взрыва 21302"/>
                </a>
            </div>
            <div>
                <a href="category-28-lego-nexo-knights">
                    <p>LEGO® NEXO KNIGHTS™</p>
                    <img src="<?=VIEW?>images/nexoBanner.jpg" alt="Конструкторы LEGO® NEXO KNIGHTS™"/>
                </a>
            </div>
            <div>
                <a href="category-24-lego-super-heroes">
                    <p>LEGO® Super Heroes</p>
                    <img src="<?=VIEW?>images/superheroesBanner.jpg" alt="Конструкторы LEGO® Super Heroes"/>
                </a>
            </div>
            <div>
                <a href="category-7-lego-friends">
                    <p>Конструкторы LEGO® Friends</p>
                    <img src="<?=VIEW?>images/friendsBanner.jpg" alt="Конструкторы LEGO® Friends"/>
                </a>
            </div>
            <div>
                <?php
                    $article = new Article();
                    $article->getFomDb(array('id'=>'9'), $conn);
                ?>
                <a href="article-9-novinki-2016-lego-ninjago">
                    <p><?=$article->title?></p>
                    <img src="<?=$article->photo?>" alt="<?=$article->title?>"/>
                </a>
            </div>
            <div>
                <?php
                    $article = new Article();
                    $article->getFomDb(array('id'=>'7'), $conn);
                ?>
                <a href="category-13-lego-minecraft">
                    <p><?=$article->title?></p>
                    <img src="<?=$article->photo?>" alt="<?=$article->title?>"/>
                </a>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
             $('.slider').slick({
                   autoplay: true,
                   speed: 1000,
                   arrows: false,
                   dots: true,
                   fade: false
             });
           });
         </script>
         <div class="block tabs mainTabs">
                    <ul>
                        <li>Акции</li>
                        <li>Новинки</li>
                    </ul>
                    <div>
                        <div class="actionTab">
                            <h1>АКЦИОННЫЕ ТОВАРЫ</h1>
                            <div id="newProduct">
                                <?php
                                    $arrProducts = array();
                                    $checkArr = array();
                                    $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.old_price != '0' AND t1.quantity>0 ORDER BY title ASC";
                                    $result = $conn->query($sql);
                                    while ($record = $result->fetch_object()){
                                        $product = new Product();
                                        $product = $record;
                                        $arrProducts[] = $product;
                                    }
                                    if(count($arrProducts)>9){
                                        $randArr = array();
                                        while (count($randArr)!=9){
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
                        </div>
                        <div class="newsTab">
                            <h1>НОВИНКИ КОНСТРУКТОРОВ LEGO®</h1>
                            <div id="newProduct">
                                <?php
                                    $arrProducts = array();
                                    $checkArr = array();
                                    $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.quantity AND (t1.labels LIKE '%new%') ORDER BY id DESC";
                                    $result = $conn->query($sql);
                                    while ($record = $result->fetch_object()){
                                        $product = new Product();
                                        $product = $record;
                                        $arrProducts[] = $product;
                                    }
                                    if(count($arrProducts)>9){
                                        $randArr = array();
                                        while (count($randArr)!=9){
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
                        </div>
                    </div>  
                    <script>
                    $(document).ready(function(){
                        $(".tabs").lightTabs();
                    });</script>
                </div> 
                        <div class="guarant">
            <h3>Почему мы?</h3>
            <div class="block">
                <img src="<?=VIEW?>images/guarant1.png"/> 
                <p>У нас есть офлайновый магазин в Днепре ТЦ «Гранд Плаза»</p>
            </div>
            <div class="block">
                <img src="<?=VIEW?>images/guarant2.png"/>
                <p>Мы уже 3 года работаем в Украине</p>
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
        <h2>СЕРИИ LEGO®</h2>
        <div id="catPreview"> 
            <?php
                $result = $conn->query("SELECT * FROM categories WHERE visible='1' AND id!='30' ORDER BY title ASC");
                while ($record = $result->fetch_object()){
                    $category = new Category();
                    $category = $record;
                    printCategoryCart($category);
                }
            ?>
        </div>
    </div>
</div>
