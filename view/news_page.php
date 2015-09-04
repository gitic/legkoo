<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//Запросы в Controller
?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="news">новости и акции</a> / название новости
    </div>
</div>

<div id="content" class="news">
    <div id="page">
        <img src="http://mir-kubikov.ru/upload/iblock/f14/1220x380_sw_new.jpg" class="newsImage"/>
        <h1>С 7 сентября! Долгожданные новинки LEGO® STAR WARS™</h1>
        <div class="text">
            <p>Собери Вселенную Star Wars™ с новинками от LEGO®: конструируемыми фигурами и наборами по мотивам нового фильма «Звездные Войны: Пробуждение Силы».</p>
        </div>
        <div class="newsProduct">
            <div class="productPreview">
                <a href="product-404-lego-luvr-21024">
                    <img src="content/products/404/photo.jpg" class="big"/>
                </a>
                <div class="previewTitle">
                    <p><span>Арт. 21024</span>LEGO Architecture</p>
                    <div class="clear"></div>
                    <a href="product-404-lego-luvr-21024">Лувр</a>
                </div>
                <div class="previewPrice">
                    1599 <span>грн</span>
                </div>
                <div class="previewBtn 404">
                                <span class='disabled'>
                        <input type="hidden" value="Лувр">
                        НЕТ В НАЛИЧИИ            </span>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>