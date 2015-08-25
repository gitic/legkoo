<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
if(!isset($_GET['id'])){
    die('Страница не найдена');
}
$id=$_GET['id'];
$category = new Category();
$category->getFomDb(array('id'=>$id), $conn);
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / 
        <a href="catalog">каталог</a> / 
        <a href="category-<?=$category->id?>-lego-<?=$category->translit?>"><?=$category->title?></a>
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Купить конструктор LEGO® <?=$category->title?></h1>
        <div class="catLogo">
            <img src="<?=$category->logo?>"/>
        </div>
        <script>
        $(function() {
            $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 16,
                values: [ 0, 16 ],
                slide: function( event, ui ) {
                  $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                }
            });
            $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) + " - " + $( "#slider-range" ).slider( "values", 1 ) );
        });
        </script>

        <div id="catSort">
            <div class="block">
                <i class="fa fa-angle-down"></i>
                <p>Цена: </p>
                <select>
                    <option value="0">Все</option>
                    <option value="1">12+</option>
                </select>
            </div>
            <div class="block mid">
                <p style='margin: 0 40px'>
                    <label for="amount">Возраст:</label>
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"><br><br>
                    <div style='margin: 0 40px' id="slider-range"></div>
                </p>
            </div>
            <div class="block">
                <i class="fa fa-angle-down"></i>
                <p>Сортировать по: </p>
                <select>
                    <option value="" selected="selected">По умолчанию</option>
                    <option value="">Наименование (А -&gt; Я)</option>
                    <option value="">Наименование (Я -&gt; А)</option>
                    <option value="">Цена (по возрастанию)</option>
                    <option value="p">Цена (по убыванию)</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div id="catProduct">
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.category='$id' ORDER BY id DESC";
                $result = $conn->query($sql);
//                echo $conn->error;
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
    </div>
</div>
