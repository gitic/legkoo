<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/statesJs.js"></script>

<h1>
    Метки товара
</h1>

<div id="top-btn">
        <a href="?view=state_add"><i class="fa fa-plus"></i> Добавить статус</a>
</div>
<p class='error'><span></span></p>
<div id="content">
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>id</td>
                            <td width="550">Название</td>
                            <td>цвет</td>
                            <td></td>
                            <td></td>
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?=print_states($conn);?>
                </tbody>
        </table>
</div>