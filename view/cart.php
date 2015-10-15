<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
//внешний обработчик в папке controller
?>
<script src="<?=VIEW?>js/cartJs.js"></script>
<div id="breadcrumbs" style='display:none'>
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="cart">корзина</a>
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Корзина покупок</h1>
        <p class="error">Произошла ошибка</p>
        <div id="order">
            <?php if(isset($cookie) && count($cookie) != 0):?>
            <table cellspacing="0">
                <thead>
                    <tr>
                        <td class="orderFoto">
                           Фото 
                        </td>
                        <td class="orderTitle">
                           Название товара 
                        </td>
                        <td class="orderCount">
                           Кол
                        </td>
                        <td class="orderPrice">
                            Итого
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody class="mainBody">
                    <?php
                    $ids = '';
                    foreach ($cookie as $x) {$ids.=$x->id.',';}
                    $ids = substr($ids, 0, strripos($ids, ','));
                        $result = $conn->query("SELECT * FROM products WHERE id IN ($ids) ORDER BY FIND_IN_SET(id,'$ids')");
                        $i = 0;
                        $amount = 0;
                        while ($record = $result->fetch_object()):
                            $product = new Product();
                            $product = $record;
                    ?>
                        <tr>
                            <td class="orderFoto">
                               <img src="<?=$product->photo?>"/> 
                            </td>
                            <td class="orderTitle">
                                <span>Артикул: <?=$product->articul?></span>
                               <a href="product-<?=$product->id?>-lego-<?=$product->translit?>-<?=$product->articul?>" target="_blank"><?=$product->title?></a>
                            </td>
                            <td class="orderCount <?=$i?>">
                               <input value="<?=$cookie[$i]->count?>" type="text" />
                            </td>
                            <td class="orderPrice <?=$i?>">
                                <?php
                                    $price = $product->price * $cookie[$i]->count;
                                    $amount = $amount + $price;
                                ?>
                                <strong><?=$price?></strong> грн
                            </td>
                            <td class="orderDel <?=$i?>">
                                <span class="del">
                                    <i class="fa fa-times-circle-o"></i>
                                </span>
                            </td>
                        </tr>
                    <?php $i++;endwhile;?>
                        <tr>
                            <td class="orderFoto"></td>
                            <td colspan="5" class="sum">Итого: <strong><?=$amount?></strong> грн <br> <a href="info-7" class="discInfo" target="_blank">хочу скидку!</a></td>
                        </tr>
                </tbody>
            </table>
            <div id="steps">
                <form id='cart_form' name="cart_form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <h3><em>1</em> Контактная информация:</h3>
                <div class="step">
                    <span>Все поля (<span style="color:red;display: inline">*</span>) обязательны для заполнения.</span>
                        <div class="block">
                            <strong><span style="color:red;display: inline">*</span> Имя или фамилия</strong>
                            <input placeholder="Имя или фамилия" name ="fio" value="" type="text" class="inp fio"/>
                            <span>для обращения к Вам</span>
                        </div>
                        <div class="block">
                            <strong><span style="color:red;display: inline">*</span> E-Mail</strong>
                            <input placeholder="E-Mail" name ="email" value="" type="email" class="inp email"/>
<!--                            <span>для отправки деталей заказа</span>-->
                        </div>
                        <div class="block">
                            <strong><span style="color:red;display: inline">*</span> Телефон</strong>
                            <input placeholder="Телефон для связи" name="phone" value="" type="text" class="inp phone phoneMask"/>
                            <span>для уточнения деталей</span>
                        </div>
                        <div class="block">
                            <strong>Комментарий к заказу</strong>
                            <textarea placeholder="Комментарий к заказу" name="comment" rows="5"></textarea>
                        </div>
                </div>
                <h3><em>2</em> Способ доставки:</h3>
                <div class="step">
                        <div class="block">
                            <strong><span style="color:red;display: inline">*</span> Выберите способ доставки:</strong>
                            <select class='delivery_type' name="delivery_type">
                                <option value="0">---</option>
                                <option value="1">На склад "Новой Почты" (за счет получателя).</option>
                                <option value="2">Адресная доставка по Украине(Новая Почта).</option>
                                <option value="3">Самовывоз.</option>
                            </select><br><br>
                            <div style='display: none' class='npBlock'>
                                <input autocomplete="off" placeholder="Город" id='delivery_city' value="" type="text" class="inp"/><br><br>
                                <select id='select_delivery_adress'>
                                    <option value='0'>---</option>
                                </select><br><br>
                            </div>
                            <input autocomplete="off" placeholder="Адрес доставки" id='delivery_adress' name="delivery_adress" value="" type="hidden" class="inp"/>
                        </div>
                </div>
                <h3><em>3</em> Способ оплаты:</h3>
                <div class="step">
                        <div class="block">
                            <strong><span style="color:red;display: inline">*</span> Выберите способ оплаты:</strong>
                            <select class="payment_type" name="payment_type">
                                <option value="0">---</option>
                                <option value="1">Наличными при получении</option>
                                <option value="2">Кредитная карта</option>
                            </select>
                        </div>
                </div>
                <h3><em>4</em> Подтверждение:</h3>
                <div class="step">
                    <div class="block conf">
                        <p>Имя: <strong id='fio'></strong></p>
                        <p>Электронная почта: <strong id='email'></strong></p>
                        <p>Телефон: <strong id='phone'></strong></p>
                        <p>Точное время доставки уточнит менеджер при согласовании деталей заказа</p>
                        <p>Цена: <strong id='price'><?=$amount?> грн</strong></p>
                    </div>
                </div>
                <div class="block">
                    <input type="checkbox" id="aggr"> <label for="aggr">Я прочитал и согласен с правилами <a href="info-4" target="_blank">Условия соглашения</a></label>
                    <div class="clear"></div>
                    <div class="btn buy">
                        <input disabled disabled="disabled" class="send" name="submit" type="submit" value="ОФОРМИТЬ ЗАКАЗ" />
                    </div><div class="clear"></div>
                </div>
                </form>
            </div>
            <?php else:?>
                <p style="text-align: center">Корзина пуста</p>
            <?php endif;?>
        </div>
        
    </div>
    <?php if($error){echo '<script>showError();</script>';}?>
</div>
