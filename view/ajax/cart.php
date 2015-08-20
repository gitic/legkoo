<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type']) && isset($_POST['rowID'])){
    $rowId = $_POST['rowID'];
    $product = new Product();
    $success = $product->getFomDb(array('id'=>$rowId), $conn);
    if($success){
        echo $product->price; 
    }
    else{
        echo 'error'; 
    }
}
else{
    echo 'error';
}