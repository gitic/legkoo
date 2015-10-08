<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<div id="content">
    <div id="main">
        <div id="slider">
            <div>        
                <a href="info-3">
                    <p>Лайк акция</p>
                    <img src="<?=VIEW?>images/likeaction.jpg" alt="Лайкакция"/>
                </a>
            </div>
            <div>        
                <a href="info-3">
                    <p>Лайк акция</p>
                    <img src="<?=VIEW?>images/likeaction.jpg" alt="Лайкакция"/>
                </a>
            </div>
        </div>
        <script type="text/javascript">		
            $(document).ready(function(){ $('#slider').jshowoff({ speed:3000 }); });
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
