<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="#">главная</a> / каталог
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Каталог LEGO</h1>
        <div id="catPreview">            
            <a href="?view=category_page" class="catPreviewBlock">
                <img src="<?=VIEW?>images/bionicle.jpg"/>
            </a>
        </div>
    </div>
</div>