<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

//$result = $conn->query("SELECT * FROM orders GROUP BY email HAVING COUNT(*) > 1");
//while ($record = $result->fetch_object()){
//    print_arr($record);
//}
?>
<!--<script src="<?=VIEW?>js/articlesJs.js"></script>-->

<h1>
    Список клиентов
</h1>

<div id="top-btn">
        <!--<a href="?view=client_add"><i class="fa fa-plus"></i> Добавить клиента</a>-->
</div>
<p class='error'><span></span></p>
<div id="content">
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>id</td>
                            <td>Имя</td>
                            <td>E-mail</td>
                            <td>Кол-во заказов</td>
                            <!--<td width="550">Название</td>-->
                            <td></td>
                            <!--<td></td>-->
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?php
                        print_clients($conn);
                    ?>
                </tbody>
        </table>
</div>