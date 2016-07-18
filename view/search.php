<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(!isset($_GET['search'])){
    die('Неверный формат запроса');
}
$searchStr = $_GET['search'];
$searchStr = clear($conn, $searchStr);
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / 
        <span>поиск</span>
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Поиск "<?=$searchStr?>":</h1>
        <?php 
            $result = $conn->query("SELECT MIN(price) AS minPrice, MAX(price) AS maxPrice,MIN(age_from) AS ageFrom, MAX(age_to) AS ageTo, MIN(elements) AS minElements, MAX(elements) AS maxElements FROM products");
            $record = $result->fetch_object();
            $minPrice = $record->minPrice;
            $maxPrice = $record->maxPrice;
            $ageFrom = $record->ageFrom;
            $ageTo = $record->ageTo;
            $elsFrom = $record->minElements;
            $elsTo = $record->maxElements;
            
            
        ?>
        <?php
        
            if(strlen($searchStr) < 1){
                echo 'Введите не менее трех символов';
            }
            else{
                $searchStr = preg_replace('/[\s]{2,}/', ' ', $searchStr);
                $words = explode(' ',$searchStr);
                $category = 0;
                $cat="(title LIKE '%$words[0]%'";
                if(count($words)>1){
                    for($i=1;$i<count($words);$i++){$cat.="AND title LIKE '%$words[$i]%'";}$cat.=')';
                }
                else {$cat.=')';}
                $sql = "SELECT * FROM categories WHERE $cat AND visible='1' LIMIT 0,1";
                $result = $conn->query($sql);
                if($result->num_rows > 0){$category = $result->fetch_object();$category = $category->id;}
                

                $q="(t1.title LIKE '%$words[0]%'";
                if(count($words)>1){
                    for($i=1;$i<count($words);$i++){$q.="OR t1.title LIKE '%$words[$i]%'";}$q.=')';
                }
                else {$q.=')';}
                
                $q2="(t1.articul LIKE '%$words[0]%'";
                if(count($words)>1){
                    for($i=1;$i<count($words);$i++){$q2.="OR t1.articul LIKE '%$words[$i]%'";}$q2.=')';
                }
                else {$q2.=')';}
                
                $sql = "SELECT t1.*,t2.title AS catName,t2.id AS catId FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE ($q OR $q2) AND t1.visible='1' UNION "
                        . "SELECT t1.*,t2.title AS catName,t2.id AS catId FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.category=$category AND t1.visible='1' "
                        . "ORDER BY category ASC,id DESC";
                $result = $conn->query($sql);
                echo $conn->error;
                while($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    $goods[] = $product;
                }
            }  
            ?>
        <script>
        $(function() {
            //Цена
            $( "#slider-price" ).slider({
                range: true,
                min: <?=$minPrice?>,
                max: <?=$maxPrice?>,
                values: [ <?=$minPrice?>, <?=$maxPrice?> ],
                slide: function( event, ui ) {
                  $( "#amount_price" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] + ' грн');
                },
                change: function( event, ui ) {
                    var pFrom = ui.values[0];
                    var pTo = ui.values[1];
                    $( "#priceHide1" ).val(pFrom);
                    $( "#priceHide2" ).val(pTo);
                    sendSearchData();
                }
            });
            $( "#amount_price" ).val( "" + $( "#slider-price" ).slider( "values", 0 ) + " - " + $( "#slider-price" ).slider( "values", 1 ) + ' грн');
            $( "#priceHide1" ).val($( "#slider-price" ).slider( "values", 0 ));
            $( "#priceHide2" ).val($( "#slider-price" ).slider( "values", 1 ));
           
            //Возраст
            $( "#slider-age" ).slider({
                range: true,
                min: <?=$ageFrom?>,
                max: <?=$ageTo?>,
                values: [ <?=$ageFrom?>, <?=$ageTo?> ],
                slide: function( event, ui ) {
                  $( "#amount_age" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
                },
                change: function( event, ui ) {
                    var ageFrom = ui.values[0];
                    var ageTo = ui.values[1];
                    $( "#ageHide1" ).val(ageFrom);
                    $( "#ageHide2" ).val(ageTo);
                    sendSearchData();
                }
            });
            $( "#amount_age" ).val( "" + $( "#slider-age" ).slider( "values", 0 ) + " - " + $( "#slider-age" ).slider( "values", 1 ));
            $( "#ageHide1" ).val($( "#slider-age" ).slider( "values", 0 ));
            $( "#ageHide2" ).val($( "#slider-age" ).slider( "values", 1 ));
            
            //Количество деталей
            $( "#slider-elements" ).slider({
                range: true,
                min: <?=$elsFrom?>,
                max: <?=$elsTo?>,
                values: [ <?=$elsFrom?>, <?=$elsTo?> ],
                slide: function( event, ui ) {
                  $( "#amount_elements" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]);
                },
                change: function( event, ui ) {
                    var elsFrom = ui.values[0];
                    var elsTo = ui.values[1];
                    $( "#elsHide1" ).val(elsFrom);
                    $( "#elsHide2" ).val(elsTo);
                    sendSearchData();
                }
            });
            $( "#amount_elements" ).val( "" + $( "#slider-elements" ).slider( "values", 0 ) + " - " + $( "#slider-elements" ).slider( "values", 1 ));
            $( "#elsHide1" ).val($( "#slider-elements" ).slider( "values", 0 ));
            $( "#elsHide2" ).val($( "#slider-elements" ).slider( "values", 1 ));
            
            $('.categories').on('change',function (){
                sendSearchData();
            })
            function sendSearchData(){
                var string = $('#searchStrHide').val();
                var priceFrom = $('#priceHide1').val();
                var priceTo = $('#priceHide2').val();
                var ageFrom = $('#ageHide1').val();
                var ageTo = $('#ageHide2').val();
                var elsFrom = $('#elsHide1').val();
                var elsTo = $('#elsHide2').val();
                var cats = [];
                var i = 0;
                $( ".categories" ).each(function() {
                    if($(this).is(':checked')){
                       cats[i] = $(this).val();
                       i++;
                    };
                });
                cats = cats.join();
                var sendData = {
                    serchStr:string,
                    priceFrom:priceFrom,
                    priceTo:priceTo,
                    ageFrom:ageFrom,
                    ageTo:ageTo,
                    elsFrom:elsFrom,
                    elsTo:elsTo,
                    categories:cats
                }
                sendData = JSON.stringify(sendData);
                $.ajax({
                    url:'./?ajax=search',
                    type:'POST',
                    data: {searchData:sendData},
                    success: function (data, textStatus, jqXHR) {
                        $('#ajaxConteiner').html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus+' '+errorThrown);
                    }
                });            }
        }
        );
        </script>
        <div id="catSort">
            <input id="searchStrHide" hidden type="hidden" value="<?=$searchStr?>">
            <div class="block">
                <p style='margin: 0 40px'>
                    <label for="amount_price">Цена:</label>
                    <input type="text" id="amount_price" readonly style="border:0; color:#333; background-color:#f5f5f5; font-weight:bold;"><br>
                    <input type="hidden" id="priceHide1" value="">
                    <input type="hidden" id="priceHide2" value="">
                    <div style='margin: 0 40px' id="slider-price"></div>
                </p>
            </div>
            <div class="block">
                <p style='margin: 0 40px'>
                    <label for="amount_age">Возраст:</label>
                    <input type="text" id="amount_age" readonly style="border:0; color:#333; background-color:#f5f5f5; font-weight:bold;"><br>
                    <input type="hidden" id="ageHide1" value="">
                    <input type="hidden" id="ageHide2" value="">
                    <div style='margin: 0 40px' id="slider-age"></div>
                </p>
            </div>
            <div class="block">
                <p style='margin: 0 40px'>
                    <label for="amount_elements">Деталей:</label>
                    <input type="text" id="amount_elements" readonly style="border:0; color:#333; background-color:#f5f5f5; font-weight:bold;"><br>
                    <input type="hidden" id="elsHide1" value="">
                    <input type="hidden" id="elsHide2" value="">
                    <div style='margin: 0 40px' id="slider-elements"></div>
                </p>
            </div>
            <div class="clear"></div>
            <div class="block" style='margin: 10px 40px'>
                <?php
                    if(isset($goods)):
                        $product = $goods[0];
                        for($i=0;$i<count($goods);$i++):
                            if($i!=0 && ($product->catId == $goods[$i]->catId)){
                                continue;
                            }
                            $product = $goods[$i];
                ?>
                <input checked="" type="checkbox" class="categories" id="cat<?=$product->catId?>" name="cat<?=$product->catId?>" value="<?=$product->catId?>"> <label for="cat<?=$product->catId?>"><?=$product->catName?></label><br>
                <?php endfor;
                endif;?>
            </div>
            <div class="clear"></div>
        </div>
        <div id="ajaxConteiner" class="search">
            <?php
                if(isset($goods)){
                    for($i=0;$i<count($goods);$i++){
                    printProductCart($goods[$i]);
                    }
                }
                else {
                    echo "Нет результатов по запросу '$searchStr'";
                }
            ?>
            <div class="clear"></div>
        </div>
    </div>
</div>
