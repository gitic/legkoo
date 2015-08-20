<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$cookie = $_COOKIE["mlscart"];
$cookie = json_decode($cookie);
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
                <tbody>
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
                                <strong><span><?=$product->price * $cookie[$i]->count ?></span> грн</strong>
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
        </div>
    </div>
</div>