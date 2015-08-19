<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

?>

<div id="breadcrumbs">
    <div id="breadcrumbsBody">
        <a href="#">главная</a> / корзина
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
                    <tr>
                        <td class="orderFoto">
                           <img src="http://novodom.dp.ua/content/products/1/gallery/6.jpg"/> 
                        </td>
                        <td class="orderTitle">
                            <span>Артикул: 21121</span>
                           <a href="#" target="_blank">Архитектурная студия</a>
                        </td>
                        <td class="orderCount">
                           <input value="1" type="text" />
                        </td>
                        <td class="orderSale">
                            <span>10%</span>
                        </td>
                        <td class="orderPrice">
                            <strong>15000 грн</strong>
                        </td>
                        <td class="orderDel">
                            <span class="del">
                                <i class="fa fa-times"></i>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="orderFoto">
                           <img src="http://novodom.dp.ua/content/products/1/gallery/6.jpg"/> 
                        </td>
                        <td class="orderTitle">
                            <span>Артикул: 21121</span>
                           <a href="#" target="_blank">Архитектурная студия</a>
                        </td>
                        <td class="orderCount">
                           <input value="1" type="text" />
                        </td>
                        <td class="orderSale">
                            <span>10%</span>
                        </td>
                        <td class="orderPrice">
                            <strong>15000 грн</strong>
                        </td>
                        <td class="orderDel">
                            <span class="del">
                                <i class="fa fa-times"></i>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="orderFoto">
                           <img src="http://novodom.dp.ua/content/products/1/gallery/6.jpg"/> 
                        </td>
                        <td class="orderTitle">
                            <span>Артикул: 21121</span>
                           <a href="#" target="_blank">Архитектурная студия</a>
                        </td>
                        <td class="orderCount">
                           <input value="1" type="text" />
                        </td>
                        <td class="orderSale">
                            <span>10%</span>
                        </td>
                        <td class="orderPrice">
                            <strong>15000 грн</strong>
                        </td>
                        <td class="orderDel">
                            <span class="del">
                                <i class="fa fa-times"></i>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>