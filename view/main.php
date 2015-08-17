<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="topMenu">
    <div id="topMenuFirst">
        <div id="searchField">
            <i class="fa fa-search"></i><input value="" type="text" placeholder="Введите название или артикул" class="inp"/><input value="ПОИСК" type="submit" class="btn"/>
        </div>
        <a href="<?=PATH?>" id="logo"><img src="<?=VIEW?>images/logo.png"/></a>
    </div>
    <div id="topMenuSecond">
        <div id="topMenuSecondBody">
            <a href="#" id="basketSmall">
                <i class="fa fa-shopping-cart"></i> ТОВАРОВ: 0
            </a>
            <nav>
                <ul>
                    <li>
                        <a href="#"><span>главная</span></a>
                    </li>
                    <li>
                        <a href="#"><span>каталог</span></a>
                    </li>
                    <li>
                        <a href="#"><span>новости и акции</span></a>
                    </li>
                    <li>
                        <a href="#"><span>доставка и оплата</span></a>
                    </li>
                </ul>
            </nav>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="breadcrumbs">
<!--    <div id="breadcrumbsBody">
        <a href="#">главная</a> / каталог
    </div>-->
</div>

<div id="content">
    <div id="main">
        <div id="slider">
            <img src="<?=VIEW?>images/banner.jpg" alt=""/>
        </div>
        <h3>НОВИНКИ LEGO</h3>
        <h3>СЕРИИ LEGO</h3>
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

<div id="subscribe">
    <div id="subscribeBody">
        <div class="social">
            <a href="#"><i class="fa fa-vk"></i></a>
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div id="footer">
    <div id="footerBody">
        <div class="footLogo">
            <img src="<?=VIEW?>images/logo.png"/>
        </div>
    </div>
</div>

<div id="copyright">
    ds
</div>