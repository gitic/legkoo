<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<noindex>
    <div class='notify addNotify'>
        <div>
            <strong>Товар "<span></span>" добавлен в корзину</strong>
            <p><a rel="nofollow" href="cart" class="btn">ОФОРМИТЬ ЗАКАЗ</a><span class="skipNotify">ПРОДОЛЖИТЬ ПОКУПКИ</span>
            <div class="clear"></div></p>
        </div>
    </div>
    <div class='notify orderSend'>
        <div>
            <strong>Спасибо за ваш заказ!</strong>
            <p><em>Наш менеджер свяжется с Вами для уточнения заказа в ближайшее время.</em></p>
            <p><span class="skipNotify">ЗАКРЫТЬ</span>
            <div class="clear"></div></p>
        </div>
    </div>
</noindex>
<div id="contactsLine">
    <div id="contactsLineBody">
        <span>EMail: <a href="mailto:legodnepr@gmail.com">legodnepr@gmail.com</a></span>
        Тел: +38(067)567-82-44 (с 10:00 до 20:00)
    </div>
</div>
<div id="topMenu">
    <div id="topMenuFirst">
        <form id="searchField">
            <i class="fa fa-search"></i><input value="" type="text" placeholder="Введите название или артикул" class="inp"/><input value="поиск" type="submit" class="btn"/>
        </form>
        <a href="<?=PATH?>" id="logo"><img src="<?=VIEW?>images/logo.png"/></a>
    </div>
    <div id="topMenuSecond">
        <div id="topMenuSecondBody">
            <noindex>
                <a rel="nofollow" href="cart" id="basketSmall">
                    <i class="fa fa-shopping-cart"></i> <em>ТОВАРОВ:</em> <span>0</span>
                </a>
            </noindex>
            <nav class="clearfix">
                <ul class="clearfix">
                    <li>
                        <a href="<?=PATH?>"><span>главная</span></a>
                    </li>
                    <li>
                        <a href="catalog"><span>каталог</span></a>
                    </li>
<!--                    <li>
                        <a href="#"><span>новости и акции</span></a>
                    </li>-->
                    <li>
                        <a href="info-1"><span>доставка и оплата</span></a>
                    </li>
                    <div class="clear"></div>
                </ul>
                <a href="#" id="pull"><i class="fa fa-bars"></i></a>
            </nav>
            <div class="clear"></div>
        </div>
    </div>
</div>
