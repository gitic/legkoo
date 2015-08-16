<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/infoPagesJs.js"></script>
<h1>
        Инфостраницы
</h1>

<div id="top-btn">
    <a href="?view=info_page_add"><i class="fa fa-plus"></i> Добавить страницу</a>
</div>
<p class='error'><span></span></p>
<div id="content">
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>id</td>
                            <td width="550">Название</td>
                            <td></td>
                            <td></td>
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?php
                    ////// Вывод списка страниц
                        $result = $conn->query('SELECT id,title FROM info_pages ORDER BY id DESC');
                        while (list($id, $title) = $result->fetch_array()){
                            echo    "<tr>"
                                    . "<td>{$id}</td>"
                                    . "<td><span>{$title}</span></td>"
                                    . "<td><a class='row edit {$id}' href='?view=info_page_edit&id={$id}' title='Редактировать'><i class='fa fa-pencil'></i></a></td>"
                                    . "<td><a class='row del {$id}' href='#' title='Удалить'><i class='fa fa-times'></i></a></td>"
                                    . "</tr>";
                        }
                        $result->free();
                    //////
                    ?>
                </tbody>
        </table>
</div>