<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
// Запрос в Controller
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <?=$infopage->title?>
    </div>
</div>

<div id="content">
    <div id="info">
        <h1><?=$infopage->title?></h1>
        <div class="text">
            <?=$infopage->text?>
        </div>
        <div class="actionBtn">Поделиться:
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
<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="disable" data-share-style="1" data-mode="share" data-like-text-enable="false" data-mobile-view="false" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp.mr." data-share-size="40" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1421867" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="true" data-selection-enable="false" class="uptolike-buttons" ></div>
</div>
    </div>
</div>
