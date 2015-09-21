<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
require_once 'lib/SendMailSmtpClass.php';

if(isset($_POST['rowId'])){
    $rowId = clear($conn, htmlentities($_POST['rowId']));
    $phone = clear($conn, htmlentities($_POST['phone']));
    if($phone == ''){
        die('error');
    }
    $product = new Product();
    $product->getFomDb(array('id'=>$rowId), $conn);
    $orderCart[] = array('id'=>$product->id,'title'=>$product->title,'articul'=>$product->articul,'category'=>$product->category,'count'=>'1','price'=>$product->price,'img'=>$product->photo);
    $sum = $product->price;
    $products = json_encode($orderCart,JSON_UNESCAPED_UNICODE);
    
    $order = new Order();
    $order->status = 1;
    $order->fio = "в 1 клик ".$phone;
    $order->phone = $phone;
    $order->products = $products;
    $order->sum = $sum;
    $order->total = $sum;
    $order->date_add = date('Y-m-d H:i:s');
    $order->client_ip = getRealIp();
    
    $success = $success = $order->insert($conn);
    if($success){
        $orderId = $conn->insert_id;
        $date = date("j.m.Y, H:i", strtotime($order->date_add));
        $subject = "Заказ в 1 клик №".$orderId." от $date - ".TITLE;
        $message = templateNewOrder($subject, PATH."/adminka/?view=order_edit&id=$orderId", $order->fio, $order->email, $order->phone, $order->comment, $sum, '0', '0', $sum, $orderCart);
        sendSMTPgmail(TITLE, 'glink0504@gmail.com,zymainfo@gmail.com,legodnepr@gmail.com', $subject, $message);
    }
    else{
        echo 'error'; 
    }
}
else{
    echo 'error';
}