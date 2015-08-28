<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$pageDir = 'labels';

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление статьи
        case 'del':
            $rowID = $_POST['rowID'];
            $result = $conn->query("DELETE FROM $pageDir WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
            //////// Вывод списка товаров
            print_labels($conn);
            ////////
            die();
            break;
    }
}
else if(!isset($_POST['cat_id'])){
    die('Неверный запрос');
}