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
        <div class="actionBtn">Поделиться:<br/><br/>
            
<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="transparent" data-options="big,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir" data-user="1425727279"></div>
            
</div>
    </div>
</div>
