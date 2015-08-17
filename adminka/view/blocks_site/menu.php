<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>
<div id="menu">	
    <div id="logo">
        <i class="fa fa-cutlery"></i>
        <a href="http://www.ricettio.com/" target="_blank">
                ricettio.com <i class="fa fa-external-link"></i>
                <span>перейти на сайт</span>
        </a>
        <div class="clear"></div>
    </div>
<ul>
    <li class="tl">
            Контент
    </li>
    <li>
        <a href="?view=info_pages" class="<?php if($view == 'info_pages'){echo 'sel';}?>">Инфостраницы <i class="fa fa-leaf"></i></a>
    </li>
    <li>
        <a href="?view=articles" class="<?php if($view == 'articles'){echo 'sel';}?>">Статья или новость <i class="fa fa-leaf"></i></a>
    </li>
    <li>
        <a href="?view=products" class="<?php if($view == 'products'){echo 'sel';}?>">Товары <i class="fa fa-leaf"></i></a>
    </li>
</ul>
<ul>
    <li class="tl">
            Управление контентом
    </li>
    <li style='position: absolute;bottom: 10px;width: 100%;text-align: center'>
        <a href="?view=exit">Выход</a>
    </li>
</ul>
        </div>