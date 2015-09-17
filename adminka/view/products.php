<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/productsJs.js"></script>

<h1>
    Список товаров
</h1>

<div id="top-btn">
        <a href="?view=product_add"><i class="fa fa-plus"></i> Добавить товар</a>
</div>
<p class='error'><span></span></p>
<div id="content">
        <div class="block">
            <label for='sbox'>Поиск</label>
            <input class="inp sbox" id="sbox" name="sbox" style="width:494px" value="" placeholder="Название товара или артикул"/>
        </div>
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>видимость</td>
                            <td>id</td>
                            <td>Нов</td>
                            <td>Акц</td>
                            <td>Хит</td>
                            <td>Экскл</td>
                            <td>Скоро</td>
                            <td>Б/д</td>
                            <td>Артикул</td>
                            <td width="550">Название</td>
                            <td>Количество</td>
                            <td>Цена</td>
                            <td></td>
                            <!--<td></td>-->
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?=print_products($conn);?>
                </tbody>
        </table>
</div>