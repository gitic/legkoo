<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление статьи
        case 'del':
            $rowID = $_POST['rowID'];
            //Удаление дирректории сайта
            $dir = '../'.CONTENT.'articles/'.$rowID;
            if(is_dir($dir)){
                delDir($dir);
            }
            $result = $conn->query("DELETE FROM articles WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
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
            die();
            break;
            
        //Изменение видимости статьи
        case 'visible':
            $rowID = $_POST['rowID'];
            $setVisible = $_POST['visible'];
            $values = array('visible'=>$setVisible);
            
            $selector = array('id'=>$rowID);
            $success = Article::updateArticle($values, $selector, $conn);
            if(!$success){
                die('error');
            }
            else{
                echo $setVisible;
            }
            break;
    }
}
else{
    die('Неверный запрос');
}