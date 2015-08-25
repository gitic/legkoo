<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$error = false;
if(isset($_POST['submit']) && isset($_COOKIE['mlscart'])){
    $postCookie = $_COOKIE['mlscart'];
    $postCart = json_decode($postCookie);
    $sum = 0;
    foreach ($postCart as $x) {
        $product = new Product();
        $product->getFomDb(array('id'=>$x->id), $conn);
        $orderCart[] = array('id'=>$product->id,'title'=>$product->title,'articul'=>$product->articul,'count'=>$x->count,'price'=>$product->price,'img'=>$product->photo);
        $sum = $sum + $x->count * $product->price;
    }
    $orderCart = json_encode($orderCart,JSON_UNESCAPED_UNICODE);
    
    $order = new Order();
    
    $order->fio = clear($conn, htmlentities($_POST['fio']));
    $order->email = clear($conn, htmlentities($_POST['email']));
    $order->phone = clear($conn, htmlentities($_POST['phone']));
    $order->comment = clear($conn, htmlentities($_POST['comment']));
    $order->delivery_type = preg_replace('/[^0-9]+/ui', '', $_POST['delivery_type']);
    $order->delivery_adress = clear($conn, htmlentities($_POST['delivery_adress']));
    $order->payment_type = preg_replace('/[^0-9]+/ui', '', $_POST['payment_type']);
    $order->products = $orderCart;
    $order->sum = $sum;
    $order->date_add = date('Y-m-d H:i:s');
    
    $success = $order->insert($conn);
    if(!$success){
        $error = true;
    }
    else{
        unset($_COOKIE['mlscart']);
        setcookie("mlscart", '', time()-300);
        unset($_COOKIE['mlscartnum']);
        setcookie("mlscartnum", '', time()-300);
        echo '<script type="text/javascript">window.location = "'.PATH.'"</script>';
        die();
    }
}
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
                            <td class="orderSale">
                                <span><?=$product->discount?></span>
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
                            <td colspan="5" class="sum">Итого: <strong><?=$amount?></strong> грн</td>
                        </tr>
                </tbody>
            </table>
            <div id="steps">
                <form id='cart_form' name="cart_form" action="" method="post" enctype="multipart/form-data">
                <h3><em>1</em> Контактная информация:</h3>
                <div class="step">
                    <span>Все поля обязательны для заполнения.</span>
                        <div class="block">
                            <strong>Имя</strong>
                            <input placeholder="ФИО" name ="fio" value="" type="text" class="inp fio"/>
                            <span>для обращения к Вам</span>
                        </div>
                        <div class="block">
                            <strong>E-Mail</strong>
                            <input placeholder="E-Mail" name ="email" value="" type="text" class="inp email"/>
                            <span>для отправки деталей заказа</span>
                        </div>
                        <div class="block">
                            <strong>Телефон</strong>
                            <input placeholder="Телефон для связи" name="phone" value="" type="text" class="inp phone"/>
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
                            <strong>Выберите способ доставки:</strong>
                            <select name="delivery_type">
                                <option value="0">---</option>
                                <option value="1">На склад "Новой Почты" (за счет получателя).</option>
                            </select>
                            <input placeholder="Номер склада" name="delivery_adress" value="" type="text" class="inp"/>
                        </div>
                </div>
                <h3><em>3</em> Способ оплаты:</h3>
                <div class="step">
                        <div class="block">
                            <strong>Выберите способ оплаты:</strong>
                            <select name="payment_type">
                                <option value="0">---</option>
                                <option value="1">Наличными при получении</option>
                            </select>
                        </div>
                </div>
                <h3><em>4</em> Подтверждение:</h3>
                <div class="step">
                    <div class="block conf">
                        <p>Имя: <strong id='fio'>куце</strong></p>
                        <p>Электронная почта: <strong id='email'></strong></p>
                        <p>Телефон: <strong id='phone'>+7 (324) 543-56-54</strong></p>
                        <p>Точное время доставки уточнит менеджер при согласовании деталей заказа</p>
                        <p>Цена: <strong id='price'><?=$amount?> грн</strong></p>
                    </div>
                </div>
                <div class="block">
                    <input type="checkbox" id="aggr"> <label for="aggr">Я прочитал и согласен с правилами <a href="#" target="_blank">Условия соглашения</a></label>
                    <div class="btn buy">
                        <input disabled disabled="disabled" class="send" name="submit" type="submit" value="ОФОРМИТЬ ЗАКАЗ" />
                    </div>
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