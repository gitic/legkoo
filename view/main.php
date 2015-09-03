<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<div id="content">
    <div id="main">
<!--        <div id="slider">
            <img src="images/banner.jpg" alt=""/>
        </div>--><br/><br/>
<center>
    <a href="http://legkoo.com.ua/category-16-lego-ninjago">
        <img src="<?=VIEW?>images/ninjagobanner.jpg" alt="" style="max-width:100%;"/>
    </a>
    </center>
        <h1>НОВИНКИ КОНСТРУКТОРОВ LEGO®</h1>
        <div id="newProduct">
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' ORDER BY id DESC LIMIT 0,3";
                $result = $conn->query($sql);
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
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