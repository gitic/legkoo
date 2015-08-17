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
                            <td>видимость</td>
                            <td>id</td>
                            <td width="550">Название</td>
                            <td></td>
                            <td></td>
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?php
                        print_articles($conn);
                    ?>
                </tbody>
        </table>
</div>