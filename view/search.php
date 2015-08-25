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
        <div id="catProduct">
            <?php
        
            if(strlen($searchStr) < 3){
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
                
                $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE ($q OR $q2) AND t1.visible='1' UNION "
                        . "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.category=$category AND t1.visible='1'"
                        . "ORDER BY id DESC";
                $result = $conn->query($sql);
                if($result->num_rows < 1){
                    echo "Нет результатов по запросу '$searchStr'";
                }
                while($record = $result->fetch_object()){
                    $product = new Product();
                    $product = $record;
                    printProductCart($product);
                }
            }  
            ?>
            <script>
                $('.m-recipe-title').each(function (e){
                    str = $(this).children().html();
                     selectWord(str,'<?=$searchStr?>',this);
                });
                function selectWord(str,replacerStr,e){
                    var replacerArr = replacerStr.split(' ');
                    for(var i=0;i<replacerArr.length;i++){
                        var n = str.toLowerCase().indexOf(replacerArr[i].toLowerCase());
                        var firstLetter = str.charAt(n);
                        var re = new RegExp(replacerArr[i],'gi');
                        var replacer = replacerArr[i].substring(1);
                        str = str.replace(re,'<span style="color:red;">'+firstLetter+replacer+'</span>');

                        $(e).children().html(str);
                    }
                }
            </script>
            <div class="clear"></div>
        </div>
    </div>
</div>
