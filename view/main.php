<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<div id="content">
    <div id="main">
        <div class="slider">
            <div>
                <?php
                    $article = new Article();
                    $article->getFomDb(array('id'=>'4'), $conn);
                ?>
                <a href="article-4-<?=$article->translit?>">
                    <p><?=$article->title?></p>
                    <img src="<?=$article->photo?>" alt="<?=$article->title?>"/>
                </a>
            </div>
            <div>
                <?php
                    $article = new Article();
                    $article->getFomDb(array('id'=>'2'), $conn);
                ?>
                <a href="article-2-<?=$article->translit?>">
                    <p><?=$article->title?></p>
                    <img src="<?=$article->photo?>" alt="<?=$article->title?>"/>
                </a>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
             $('.slider').slick({
                   autoplay: true,
                   speed: 3000,
                   arrows: false,
                   dots: true,
                   fade: true
             });
           });
         </script>
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
        <h2>СЕРИИ LEGO®</h2>
        <div id="catPreview"> 
            <?php
                $result = $conn->query("SELECT * FROM categories WHERE visible='1' ORDER BY title ASC");
                while ($record = $result->fetch_object()){
                    $category = new Category();
                    $category = $record;
                    printCategoryCart($category);
                }
            ?>
        </div>
    </div>
</div>
