<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<div id="content">
    <div id="main">
        <div class="slider">
            <?php
                $article = new Article();
                $article->getFomDb(array('id'=>'2'), $conn);
            ?>
            <a href="article-2-<?=$article->translit?>">
                <p><?=$article->title?></p>
                <img src="<?=$article->photo?>" alt="<?=$article->title?>"/>
            </a>
        </div>
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