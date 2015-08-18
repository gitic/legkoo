<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="#">главная</a> / каталог
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Каталог LEGO</h1>
        <div id="catPreview">            
            <?php
                $result = $conn->query("SELECT * FROM categories WHERE visible='1'");
                while ($record = $result->fetch_object()){
                    $category = new Category();
                    $category = $record;
                    printCategoryCart($category);
                }
            ?>
        </div>
    </div>
</div>