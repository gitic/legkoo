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
        <span><i class="fa fa-pencil-square"></i> <a href="mailto:legodnepr@gmail.com">legodnepr@gmail.com</a></span>
        <i class="fa fa-phone-square"></i> +38(067)567-82-44 (с 10:00 до 20:00)
    </div>
</div>
<div id="topMenu">
    <div id="topMenuFirst">
        <a href="<?=PATH?>" id="logo"><img src="<?=VIEW?>images/logo.png"/></a>
        <form id="searchField" <?php if($view == 'cart'):?>style='display: none'<?php endif;?>>
            <i class="fa fa-search"></i><input value="" type="text" placeholder="Введите название или артикул" class="inp"/><input value="поиск" type="submit" class="btn"/>
        </form>
        <div class="slogan1">
            <a href="<?=PATH?>"><img src="<?=VIEW?>images/legkooLego.png" class="mainLogo"/></a><a href="<?=PATH?>">legkoo.com.ua</a> - интернет магазин детских конструкторов.
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
                        <a href="catalog"><span>каталог</span></a>
                    </li>
<!--                    <li>
                        <a href="actions"><span style="color:#FFD54F"><strong>Акции</strong></span></a>
                    </li>-->
                    <li>
                        <a href="info-1"><span>доставка и оплата</span></a>
                    </li>
                    <li>
                        <a href="info-6"><span><strong>кто мы?</strong></span></a>
                    </li>
                    <div class="clear"></div>
                </ul>
                <a href="#" id="pull"><i class="fa fa-bars"></i></a>
            </nav>
            <div class="clear"></div>
        </div>
    </div>
</div>

