<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//запросы в Controller
$result = $conn->query("SELECT COUNT(*) FROM products WHERE visible='1' AND category='$id'");
$total_rows = $result->fetch_array()[0];
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
        <h1>Конструкторы LEGO® <?=$category->title?></h1>
        <div class="catLogo">
            <img src="<?=$category->logo?>" alt="LEGO® <?=$category->title?>" title="LEGO® <?=$category->title?>"/>
        </div>
        <div class="catAbout">
            <?=$category->description?>
        </div>
        <?php 
            $result = $conn->query("SELECT MIN(price) AS minPrice, MAX(price) AS maxPrice,MIN(age_from) AS ageFrom, MAX(age_to) AS ageTo FROM products WHERE category = '$id';");
            $record = $result->fetch_object();
            $minPrice = $record->minPrice;
            $maxPrice = $record->maxPrice;
            $ageFrom = $record->ageFrom;
            $ageTo = $record->ageTo;
        ?>
        <script>
        $.cookie('last', 9, { expires: 7 });
        $(function() {
            $('.sortSelect').on('change',function (){
                var sortVal = $(this).val();
                var range = $('#amount_price').val().split(' ');
                var from = range[0];
                var to = range[2];
                $.cookie('last', 9, { expires: 7 });
                sendData('html','<?=$id?>','sort',from,to,sortVal,0);
            });
            $( "#slider-price" ).slider({
                range: true,
                min: <?=$minPrice?>,
                max: <?=$maxPrice?>,
                values: [ <?=$minPrice?>, <?=$maxPrice?> ],
                slide: function( event, ui ) {
                  $( "#amount_price" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] + ' грн');
                },
                change: function( event, ui ) {
                    $.cookie('last', 9, { expires: 7 });
                    var sortVal = $('.sortSelect').val();
                    sendData('html','<?=$id?>','sort',ui.values[0],ui.values[1],sortVal,0);
                }
            });
            $( "#amount_price" ).val( "" + $( "#slider-price" ).slider( "values", 0 ) + " - " + $( "#slider-price" ).slider( "values", 1 ) + ' грн');
            
            function sendData(addType,id,type,from,to,sortVal,lastEl){
                $('.showMore').remove();
                $.ajax({
                    url:'./?ajax=category_page',
                    type:'POST',
                    data: {id:id,type:type,from:from,to:to,sort:sortVal,lastEl:lastEl},
                    success: function (data, textStatus, jqXHR) {
                        if(data.trim() !== 'error'){
                            switch(addType){
                                case 'html':
                                    if(data !== 'empty'){$('#catProduct').html(data);}
                                    else{$('.showMore').css({'display':none});}
                                    break;
                                case 'append':
                                    if(data !== 'empty'){$('#catProduct').append(data);}
                                    else{$('.showMore').css({'display':'none'});}
                                    break;
                            }
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
            $('body').on('click','.showMore',function (){
                var sortVal = $('.sortSelect').val();
                var range = $('#amount_price').val().split(' ');
                var from = range[0];
                var to = range[2];
                var lastProduct = parseInt($.cookie('last'));
                sendData('append','<?=$id?>','sort',from,to,sortVal,lastProduct);
                lastProduct = lastProduct + 9;
                $.cookie('last', lastProduct, { expires: 7 });
            });
        });
        </script>

        <div id="catSort">
            <div class="block">
                <p style='margin: 0 40px'>
                    <label for="amount_price">Цена:</label>
                    <input type="text" id="amount_price" readonly style="border:0; color:#333; background-color:#f5f5f5; font-weight:bold;"><br><br>
                    <div style='margin: 0 40px' id="slider-price"></div>
                </p>
            </div>
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
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.category='$id' ORDER BY labels DESC,quantity DESC LIMIT 0,9";
                $result = $conn->query($sql);
                while ($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            ?>
            <?php if($total_rows > 9):?>
                <span style="cursor: pointer" class="showMore">Показать еще</span>
            <?php endif;?>
        </div>
    </div>
</div>
