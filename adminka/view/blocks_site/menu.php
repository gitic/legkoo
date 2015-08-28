<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>
<div id="menu">	
    <div id="logo">
        <i class="fa fa-cubes"></i>
        <a href="<?=PATH?>" target="_blank">
                LegoShop <i class="fa fa-external-link"></i>
                <span>перейти на сайт</span>
        </a>
        <div class="clear"></div>
    </div>
<ul>
    <li class="tl">
            Заказы
    </li>
    
    <li>
        <a href="?view=orders" class="<?php if($view == 'orders'){echo 'sel';}?>">Заказы <i class="fa fa-shopping-cart"></i></a>
    </li>
</ul>
<ul>
    <li class="tl">
            Контент
    </li>
    <li>
        <a href="?view=products" class="<?php if($view == 'products'){echo 'sel';}?>">Товары <i class="fa fa-cubes"></i></a>
    </li>
    <li>
        <a href="?view=articles" class="<?php if($view == 'articles'){echo 'sel';}?>">Статья или новость <i class="fa fa-file-o"></i></a>
    </li>
    <li>
        <a href="?view=info_pages" class="<?php if($view == 'info_pages'){echo 'sel';}?>">Инфостраницы <i class="fa fa-info"></i></a>
    </li>
    <li>
        <a href="?view=labels" class="<?php if($view == 'labels'){echo 'sel';}?>">Метки товара<i class="fa fa-info"></i></a>
    </li>
</ul>
<ul>
    <li class="tl">
            Разное
    </li>
    <li>
        <a href="?view=categories" class="<?php if($view == 'categories'){echo 'sel';}?>">Категории <i class="fa fa-sitemap"></i></a>
    </li>
    <li style='position: absolute;bottom: 10px;width: 100%;text-align: center'>
        <a href="?view=exit">Выход</a>
    </li>
</ul>
        </div>