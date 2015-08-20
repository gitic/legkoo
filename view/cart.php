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
            <?php if(isset($cookie)):?>
            <table>
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
                                <strong><?=$product->price * $cookie[$i]->count ?> грн</strong>
                            </td>
                            <td class="orderDel <?=$i?>">
                                <span class="del">
                                    <i class="fa fa-times"></i>
                                </span>
                            </td>
                        </tr>
                    <?php $i++;endwhile;?>
                </tbody>
            </table>
            <?php else:?>
                <p style="text-align: center">Корзина пуста</p>
            <?php endif;?>
        </div>
    </div>
</div>