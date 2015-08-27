<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//запросы в Controller
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
        <?php 
        echo $id;
            $result = $conn->query("SELECT MIN(price) AS minPrice, MAX(price) AS maxPrice,MIN(age_from) AS ageFrom, MAX(age_to) AS ageTo FROM products WHERE category = '$id';");
            $record = $result->fetch_object();
            $minPrice = $record->minPrice;
            $maxPrice = $record->maxPrice;
            $ageFrom = $record->ageFrom;
            $ageTo = $record->ageTo;
        ?>
        <script>
        $(function() {
            $('.sortSelect').on('change',function (){
                var sortVal = $(this).val();
                var range = $('#amount_price').val().split(' ');
                var from = range[0];
                var to = range[2];
                sendData('<?=$id?>','sort',from,to,sortVal);
            });
            $( "#slider-price" ).slider({
                range: true,
                min: <?=$minPrice?>,
                max: <?=$maxPrice?>,
                values: [ <?=$minPrice?>, <?=$maxPrice?> ],
                slide: function( event, ui ) {
                  $( "#amount_price" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                },
                change: function( event, ui ) {
                    var sortVal = $('.sortSelect').val();
                    sendData('<?=$id?>','price',ui.values[0],ui.values[1],sortVal);
                }
            });
            $( "#amount_price" ).val( "" + $( "#slider-price" ).slider( "values", 0 ) + " - " + $( "#slider-price" ).slider( "values", 1 ) );
            
            function sendData(id,type,from,to,sortVal){
                $.ajax({
                    url:'./?ajax=category_page',
                    type:'POST',
                    data: {id:id,type:type,from:from,to:to,sort:sortVal},
                    success: function (data, textStatus, jqXHR) {
                        if(data.trim() !== 'error'){
                            $('#catProduct').html(data);
                        }
                        else{
                            showError('Ошибка при удалении статьи');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus+' '+errorThrown);
                    }
                });
            }
        });
        </script>

        <div id="catSort">
            <div class="block">
                <p style='margin: 0 40px'>
                    <label for="amount_price">Цена:</label>
                    <input type="text" id="amount_price" readonly style="border:0; color:#f6931f; font-weight:bold;"><br><br>
                    <div style='margin: 0 40px' id="slider-price"></div>
                </p>
            </div>
<!--            <div class="block mid">
                <p style='margin: 0 40px'>
                    <label for="amount_age">Возраст:</label>
                    <input type="text" id="amount_age" readonly style="border:0; color:#f6931f; font-weight:bold;"><br><br>
                    <div style='margin: 0 40px' id="slider-age"></div>
                </p>
            </div>-->
            <div class="block">
                <i class="fa fa-angle-down"></i>
                <p>Сортировать по: </p>
                <select class='sortSelect'>
                    <option value="0" selected="selected">По умолчанию</option>
                    <option value="1">Наименование (А -&gt; Я)</option>
                    <option value="2">Наименование (Я -&gt; А)</option>
                    <option value="3">Цена (по возрастанию)</option>
                    <option value="4">Цена (по убыванию)</option>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div id="catProduct">
            <?php
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.category='$id' ORDER BY id DESC";
                $result = $conn->query($sql);
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
        </div>
    </div>
</div>
