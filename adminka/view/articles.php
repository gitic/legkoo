<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/articlesJs.js"></script>

<h1>
    Список статей
</h1>

<div id="top-btn">
        <a href="?view=article_add"><i class="fa fa-plus"></i> Добавить статью</a>
</div>
<p class='error'><span></span></p>
<div id="content">
        <table cellspacing="0" cellpadding="0" rules="rows" class="list">
                <thead>
                        <tr>
                            <td>visible</td>
                            <td>id</td>
                            <td width="550">title</td>
                            <td></td>
                            <td></td>
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?php
                        //////// Вывод списка статей
                        $result = $conn->query('SELECT id,title,visible,views FROM articles ORDER BY id DESC');
                        while (list($id,$title,$visible,$views) = $result->fetch_array()){
                            if($visible == 1){$visClass = 'fa fa-circle';}
                            else{$visClass = 'fa fa-circle-o';}
                            echo    "<tr>"
                                    . "<td class='visible' align='center'><a class='row visible {$id}' title='Видимость'><i class='{$visClass}'></i></a></td>"
                                    . "<td>{$id}</td>"
                                    . "<td><div class='views'><i class='fa fa-eye'></i>{$views}</div><span>{$title}</span></td>"
                                    . "<td><a class='row edit {$id}' href='?view=article_edit&id={$id}' title='Редактировать'><i class='fa fa-pencil'></i></a></td>"
                                    . "<td><a class='row del {$id}' href='#' title='Удалить'><i class='fa fa-times'></i></a></td>"
                                    . "</tr>";
                        }
                        $result->free();
                        ////////
                        ?>
                </tbody>
        </table>
</div>