<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$pageDir = 'products';

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление статьи
        case 'del':
            $sbox = $_POST['sbox'];
            $rowID = $_POST['rowID'];
            //Удаление дирректории сайта
            $dir = '../'.CONTENT.$pageDir.'/'.$rowID;
            if(is_dir($dir)){
                delDir($dir);
            }
            $result = $conn->query("DELETE FROM $pageDir WHERE id='{$rowID}'");
            $numRows = $conn->affected_rows;
            if($numRows == 0){
                die('error');
            }
            //////// Вывод списка товаров
            print_products($conn,$sbox);
            ////////
            die();
            break;
            
        //Изменение видимости статьи
        case 'visible':
            $rowID = $_POST['rowID'];
            $setVisible = $_POST['visible'];
            $values = array('visible'=>$setVisible);
            
            $selector = array('id'=>$rowID);
            $success = Product::update($values, $selector, $conn);
            if(!$success){
                die('error');
            }
            else{
                echo $setVisible;
            }
            break;
        
        //Поиск
        case 'search':
            $sbox = $_POST['sbox'];
            //////// Вывод списка товаров
            print_products($conn,$sbox);
            ////////
            break;
    }
}
else{
    die('Неверный запрос');
}