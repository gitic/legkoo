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
        <h1>КАТАЛОГ LEGO</h1>
        <div id="catPreview">            
            <a href="#" class="catPreviewBlock">
                <img src="<?=VIEW?>images/bionicle.jpg"/>
            </a>
            <a href="#" class="catPreviewBlock">
                <img src="http://legkoo.com.ua/image/cache/data/Categories/Architecture-200x267.jpg"/>
            </a>
            <a href="#" class="catPreviewBlock">
                <img src="http://legkoo.com.ua/image/cache/data/Categories/CLASSIC-200x267.jpg"/>
            </a>
            <a href="#" class="catPreviewBlock">
                <img src="http://legkoo.com.ua/image/cache/data/Categories/Disney_Princess-200x267.jpg"/>
            </a>
            <a href="#" class="catPreviewBlock">
                <img src="<?=VIEW?>images/bionicle.jpg"/>
            </a>
            <a href="#" class="catPreviewBlock">
                <img src="<?=VIEW?>images/bionicle.jpg"/>
            </a>
        </div>
    </div>
</div>