<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление ингредиента
        case 'del':
            $rowID = $_POST['rowID'];
            $result = $conn->query("DELETE FROM info_pages WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
            //////// Вывод списка страниц
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
            ////////
            die();
            break;
    }
}
else{
    die('Неверный запрос');
}