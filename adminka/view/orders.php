<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/ordersJs.js"></script>

<h1>
    Список заказов
</h1>

<div id="top-btn">
        <a href="?view=product_add"><i class="fa fa-plus"></i> Новый заказ</a>
</div>
<p class='error'><span></span></p>
<div id="content">
        <div style='display:none' class="block">
            <label for='sbox'>Поиск</label>
            <input class="inp sbox" id="sbox" name="sbox" style="width:494px" value="" placeholder="Название товара или артикул"/>
        </div>
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>Номер</td>
                            <td>Дата</td>
                            <td>Статус</td>
                            <td width="550">ФИО</td>
                            <td>Телефон</td>
                            <td>E-mail</td>
                            <td>Сумма заказа</td>
                            <td></td>
                            <!--<td></td>-->
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?= print_orders($conn);?>
                </tbody>
        </table>
</div>