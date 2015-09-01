<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$pageDir = 'orders';

if(isset($_POST['type']) && isset($_POST['rowId'])){
    $type = $_POST['type'];
    switch ($type) {
        //Удаление статьи
        case 'save':
            $rowId = $_POST['rowId'];
            $fio = clear($conn, htmlentities($_POST['fio']));
            $email = clear($conn, htmlentities($_POST['email']));
            $phone = clear($conn, htmlentities($_POST['phone']));
            $delivery_type = preg_replace('/[^0-9]+/ui', '', $_POST['delivery_type']);
            $delivery_adress = clear($conn, htmlentities($_POST['delivery_adress']));
            $payment_type = preg_replace('/[^0-9]+/ui', '', $_POST['payment_type']);
            $products = $_POST['products'];
            $sum = preg_replace('/[^0-9]+/ui', '', $_POST['sum']);
            $discount = preg_replace('/[^0-9]+/ui', '', $_POST['discount']);
            $delivery = preg_replace('/[^0-9]+/ui', '', $_POST['delivery']);
            $total = preg_replace('/[^0-9]+/ui', '', $_POST['total']);
            
            $values = array(
                'fio'=>$fio,
                'email'=>$email,
                'phone'=>$phone,
                'delivery_type'=>$delivery_type,
                'delivery_adress'=>$delivery_adress,
                'payment_type'=>$payment_type,
                'sum'=>$sum,
                'discount'=>$discount,
                'delivery'=>$delivery,
                'total'=>$total,
                'products'=>$products
            );
            $success = Order::update($values, array('id'=>$rowId), $conn);
            if(!$success){
                die("error");
            }
            else{
                echo 'Обновлено';
            }
            break;
    }
}
else {
    die('error');
}