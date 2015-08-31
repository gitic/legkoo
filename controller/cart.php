<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$error = false;
if(isset($_POST['submit']) && isset($_COOKIE['mlscart'])){
    $postCookie = $_COOKIE['mlscart'];
    $postCart = json_decode($postCookie);
    $sum = 0;
    $values = '';
    foreach ($postCart as $x) {
        $product = new Product();
        $product->getFomDb(array('id'=>$x->id), $conn);
        $orderCart[] = array('id'=>$product->id,'title'=>$product->title,'articul'=>$product->articul,'count'=>$x->count,'price'=>$product->price,'img'=>$product->photo);
        $sum = $sum + $x->count * $product->price;
        
        $newQuantity = ($product->quantity) - ($x->count);
        $values .= ",($product->id,$newQuantity)";
    }
    //Обновляем количество товаров
        $values = substr($values, 1);
        $sql = "INSERT INTO products (id,quantity) VALUES $values ON DUPLICATE KEY UPDATE quantity=VALUES(quantity)";
        $conn->query($sql);
    //Обновляем количество товаров
    $orderCart = json_encode($orderCart,JSON_UNESCAPED_UNICODE);
    
    $order = new Order();
    
    $order->fio = clear($conn, htmlentities($_POST['fio']));
    $order->email = clear($conn, htmlentities($_POST['email']));
    $order->phone = clear($conn, htmlentities($_POST['phone']));
    $order->comment = clear($conn, htmlentities($_POST['comment']));
    $order->delivery_type = preg_replace('/[^0-9]+/ui', '', $_POST['delivery_type']);
    $order->delivery_adress = clear($conn, htmlentities($_POST['delivery_adress']));
    $order->payment_type = preg_replace('/[^0-9]+/ui', '', $_POST['payment_type']);
    $order->products = $orderCart;
    $order->sum = $sum;
    $order->date_add = date('Y-m-d H:i:s');
    
    $success = $order->insert($conn);
    if(!$success){
        $error = true;
    }
    else{
        unset($_COOKIE['mlscart']);
        setcookie("mlscart", '', time()-300);
        unset($_COOKIE['mlscartnum']);
        setcookie("mlscartnum", '', time()-300);
        setcookie("notify", 'orderSend', time()+60*60*24*7);
        echo '<script type="text/javascript">window.location = "'.PATH.'"</script>';
        die();
    }
}
if(isset($_COOKIE["mlscart"])){
    $cookie = $_COOKIE["mlscart"];
    $cookie = json_decode($cookie);
}