<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
?>
<script src="<?=VIEW?>js/categoriesJs.js"></script>

<h1>
    Список Категорий
</h1>

<div id="top-btn">
        <a href="?view=category_add"><i class="fa fa-plus"></i> Новая категория</a>
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
                            <td></td>
                            <td></td>
                        </tr>
                </thead>
                <tbody id='ajaxContent'>
                    <?php
                        //////// Вывод списка категорий
                            $result = $conn->query('SELECT id,id_index,position,title,visible FROM categories ORDER BY id_index,position,title');
                            $catArr = array();
                            while (list($id,$id_index,$position,$title,$visible) = $result->fetch_array()){

                                if($id_index == 0){
                                    $catArr[$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                                }
                                else{
                                    $catArr[$id_index]['sub'][$id] = array('id'=>$id, 'id_index'=>$id_index, 'position'=>$position, 'title'=>$title,'visible'=>$visible);
                                }
                            }
                            $result->free();
                            showCatDishesRows($catArr);
                        ////////
                        ?>
                </tbody>
        </table>
</div>

