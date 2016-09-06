<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Запросы в контроллере
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="#">новости и акции</a> / <?=$article->title?>
    </div>
</div>

<div id="content" class="news">
    <div id="page">
        <img src="<?=$article->photo?>" class="newsImage"/>
        <h1><?=$article->title?></h1>
        <div class="text">
            <p><?=$article->text?></p>
        </div>
        <div class="shareBtn">
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="6" data-mode="share" data-like-text-enable="false" data-mobile-view="false" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1409452" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons" ></div>
                </div> <br/><br/>
        <div class="newsProduct">
            <?php
                if($article->products !== ''){
                    $sql = "SELECT t1.*,t2.title AS category,t2.logo_small AS cat_logo FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id WHERE t1.visible='1' AND t1.id IN ($article->products)";
                    $result = $conn->query($sql);
                    while ($product = $result->fetch_object()){
                        printProductCart($product);
                    }
                }
            ?>
        </div>
    </div>
</div>