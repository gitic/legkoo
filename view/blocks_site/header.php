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
            <p><span class="skipNotify" style="float:right;">ЗАКРЫТЬ</span>
            <div class="clear"></div></p>
        </div>
    </div>
    <div class='notify oneClick'>
        <div>
            <strong>Заказать в 1 клик</strong>
            <p><em>Введите номер телефона. Мы Вам перезвоним для оформления заказа.</em></p>
            <input class="oneClickPhone phoneMask" placeholder="Ваш номер телефона" value="" type="text"/>
            <p><span class="skipNotify cross"><i class="fa fa-times"></i></span><span id="submitOneClick">ЖДУ ЗВОНКА</span>
            <div class="clear"></div></p>
        </div>
    </div>
</noindex>
<div id="contactsLine">
    <div id="contactsLineBody">
        <div class="contacts-menu">
            <a href="info-1">Доставка и оплата</a>
            <a href="info-6">О магазине</a>
        </div>
        <span><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:+380675678244">(067)567-82-44</a></span> Пн-Вс 10<sup>00</sup> до 20<sup>00</sup>
    </div>
</div>
<div id="topMenu">
    <div id="topMenuFirst">
        <a href="<?=PATH?>" id="logo">
            <img src="<?=VIEW?>images/logo.png"/>
        </a>
        <form id="searchField" class="search-desc" <?php if($view == 'cart'):?>style='display: none'<?php endif;?>>
            <i class="fa fa-search"></i><input value="" type="text" placeholder="Артикул или название" class="inp searchField"/><input value="Поиск" type="submit" class="btn"/>
        </form>
        <div class="slogan1">
            <a href="<?=PATH?>">
                <img src="<?=VIEW?>images/logo_1.jpg" class="mainLogo"/>
                <p>интернет магазин конструкторов</p>
            </a>
        </div>
        <div class="clear"></div>
    </div>
    <div id="topMenuSecond" <?php if($view == 'cart'):?>style='display: none'<?php endif;?>>
        <div id="topMenuSecondBody">
            <noindex>
                <a rel="nofollow" href="cart" id="basketSmall">
                    <i class="fa fa-shopping-cart"></i> <em>КОРЗИНА:</em> <span>0</span> <em>тов.</em>
                </a>
            </noindex>
            <nav class="clearfix">
                <ul class="clearfix">
                    <li>
                        <a href="http://legkoo.com.ua/"><span>главная</span></a>
                    </li>
                    <li>
                        <a href="catalog"><span>каталог</span></a>
                    </li>
                    <li>
                        <a href="actions"><span>Акции</span></a>
                    </li>
                    <li>
                        <a href="new-products"><span style="color:#FFD54F">Новинки</span></a>
                    </li>
                    <li>
                        <a href="category-30-aksessuaryi"><span>Аксессуары</span></a>
                    </li>
                    <div class="clear"></div>
                </ul>
                <a href="#" id="pull"><i class="fa fa-bars"></i></a>
            </nav>
            <div class="clear"></div>
        </div>
    </div>
<div class="constr" <?php if($view == 'cart'):?>style='display: none'<?php endif;?>>
<center>
    <noindex><a rel="nofollow" href="http://goo.gl/dgfGfq" style="float:left;"><img src="<?=VIEW?>images/build1.jpg" style="max-width:100%;"/></a></noindex>
    <noindex><a rel="nofollow" href="http://goo.gl/1VoyfS" target="_blank" style="float:right;"><img src="<?=VIEW?>images/catalog2016.jpg" style="max-width:100%;"/></a></noindex>
    <div class="clear"></div>
</center></div>
</div>