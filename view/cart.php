<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
if(isset($_COOKIE["mlscart"])){
    $cookie = $_COOKIE["mlscart"];
    $cookie = json_decode($cookie);
}
?>
<script src="<?=VIEW?>js/cartJs.js"></script>
<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="<?=PATH?>">главная</a> / <a href="cart">корзина</a>
    </div>
</div>

<div id="content">
    <div id="main">
        <h1>Корзина покупок</h1>
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
                        <td class="orderSale">
                            Скидка
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
                            <td class="orderSale">
                                <span><?=$product->discount?></span>
                            </td>
                            <td class="orderPrice <?=$i?>">
                                <strong><?=$product->price * $cookie[$i]->count ?></strong> грн
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
                            <td colspan="5" class="sum">Итого: <strong>12314</strong> грн</td>
                        </tr>
                </tbody>
            </table>
            <?php else:?>
                <p style="text-align: center">Корзина пуста</p>
            <?php endif;?>
        </div>
        <div id="steps">
            <h3><em>1</em> Контактная информация:</h3>
            <div class="step">
                <span>Все поля обязательны для заполнения.</span>
                <form>
                    <div class="block">
                        <strong>Имя</strong>
                        <input value="" type="text" class="inp"/>
                        <span>для обращения к Вам</span>
                    </div>
                    <div class="block">
                        <strong>E-Mail</strong>
                        <input value="" type="text" class="inp"/>
                        <span>для отправки деталей заказа</span>
                    </div>
                    <div class="block">
                        <strong>Телефон</strong>
                        <input value="" type="text" class="inp"/>
                        <span>для уточнения деталей</span>
                    </div>
                    <div class="block">
                        <strong>Комментарий к заказу</strong>
                        <textarea rows="5"></textarea>
                    </div>
                </form>
            </div>
            <h3><em>2</em> Способ доставки:</h3>
            <div class="step">
                <form>
                    <div class="block">
                        <strong>Выберите способ доставки:</strong>
                        <select>
                            <option value="0">---</option>
                            <option value="1">На склад "Новой Почты" (за счет получателя).</option>
                        </select>
                    </div>
                </form>
            </div>
            <h3><em>3</em> Способ оплаты:</h3>
            <div class="step">
                <form>
                    <div class="block">
                        <strong>Выберите способ оплаты:</strong>
                        <select>
                            <option value="0">---</option>
                            <option value="1">Наличными при получении</option>
                        </select>
                    </div>
                </form>
            </div>
            <h3><em>4</em> Подтверждение:</h3>
            <div class="step">
                <div class="block conf">
                    <p>Имя: <strong>куце</strong></p>
                    <p>Электронная почта: <strong></strong></p>
                    <p>Телефон: <strong>+7 (324) 543-56-54</strong></p>
                    <p>Точное время доставки уточнит менеджер при согласовании деталей заказа</p>
                    <p>Цена: <strong>19 497 грн</strong></p>
                </div>
            </div>
            <div class="block">
                <input type="checkbox" id="aggr"> <label for="aggr">Я прочитал и согласен с правилами <a href="#" target="_blank">Условия соглашения</a></label>
                <div class="btn buy">
                    <a href="#" class="send">ОФОРМИТЬ ЗАКАЗ</a>
                </div>
            </div>
        </div>
    </div>
</div>