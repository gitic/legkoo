<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');
$pageDir = 'orders';


//Автозаполнение ингредиентов
if(isset($_GET['term'])){
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $sql = "SELECT id,title,articul,photo,price,category FROM products WHERE visible= '1' AND (title LIKE '%".$term."%' OR articul LIKE '%".$term."%')";
    $result = $conn->query($sql);//query the database for entries containing the term

    while ($product = $result->fetch_array())//loop through the retrieved values
    {
        $row['value']=$product['title'];
        $row['id']=(int)$product['id'];
        $row['articul']=(int)$product['articul'];
        $row['photo']=$product['photo'];
        $row['price']=$product['price'];
        $row['category']=$product['category'];
        $row_set[] = $row;//build an array
    }
    echo json_encode($row_set,JSON_UNESCAPED_UNICODE);//format the array into json data
    die();
}
if(isset($_POST['type']) && isset($_POST['rowId'])){
    $type = $_POST['type'];
    switch ($type) {
        case 'save':
            $rowId = $_POST['rowId'];
            $fio = clear($conn, htmlentities($_POST['fio']));
            $email = clear($conn, htmlentities($_POST['email']));
            $phone = clear($conn, htmlentities($_POST['phone']));
            $delivery_type = preg_replace('/[^0-9]+/ui', '', $_POST['delivery_type']);
            $delivery_adress = clear($conn, htmlentities($_POST['delivery_adress']));
            $payment_type = preg_replace('/[^0-9]+/ui', '', $_POST['payment_type']);
            $products = $_POST['products'];
            $p_unique = $_POST['p_unique'];
            $p_total = $_POST['p_total'];
            $sum = preg_replace('/[^0-9 .]+/ui', '', $_POST['sum']);
            $discount = preg_replace('/[^0-9 .]+/ui', '', $_POST['discount']);
            $delivery = preg_replace('/[^0-9 .]+/ui', '', $_POST['delivery']);
            $total = preg_replace('/[^0-9 .]+/ui', '', $_POST['total']);
            $ttn = preg_replace('/[^0-9 .]+/ui', '', $_POST['ttn']);
            
            if(isset($_COOKIE['products'])){
                $values = '';
                $oldCookie = $_COOKIE['products'];
                $oldProducts = json_decode($oldCookie);
                $newProducts = json_decode($products);
                //SET NEW COOKIE
                setcookie("products", $products, time()+60*60*24*90);
                //SET NEW COOKIE
                foreach ($oldProducts as $x) {
                    $oldArr[$x->id] = $x->count;
                }
                foreach ($newProducts as $x) {
                    $newArr[$x->id] = $x->count;
                }
                $oldElementsDel = array_diff_key ($oldArr, $newArr);
                $newElementsAdd = array_diff_key ($newArr, $oldArr);
                $changeElements = array_intersect_key($oldArr,$newArr);
                foreach ($changeElements as $key => $value) {
                    if($newArr[$key] != $value){
                        $n = $newArr[$key] - $value;
                        $values .= ",($key,$n)";
                    }
                }
                foreach ($oldElementsDel as $key => $value) {
                    $values .= ",($key,-$value)";
                }
                foreach ($newElementsAdd as $key => $value) {
                    $values .= ",($key,$value)";
                }
                $values = substr($values, 1);
                print_arr($values);
                $sql = "INSERT INTO products (id,quantity) VALUES $values ON DUPLICATE KEY UPDATE quantity = quantity - VALUES(quantity)";
                $conn->query($sql);
            }
            
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
                'products'=>$products,
                'p_unique'=>$p_unique,
                'p_total'=>$p_total,
                'ttn'=>$ttn
            );
            $success = Order::update($values, array('id'=>$rowId), $conn);
            if(!$success){
                die("error");
            }
            else{
                echo 'Обновлено';
            }
            break;
        case 'state':
            $rowId = $_POST['rowId'];
            $status = $_POST['state'];
            $conn->query("UPDATE $pageDir SET status='{$status}' WHERE id='{$rowId}'");
            break;
        case 'count':
            $str = $_POST['string'];
            $discount = $_POST['discount'];
            $delivery = $_POST['delivery'];
            $str = explode(',', $str);
            $value1 = 0;
            foreach ($str as $x) {
                $x = explode('x', $x);
                $value1 = $value1+($x[0]*$x[1]);
            }
            $value2 = $value1 - $discount + $delivery;
            echo $value1.'+'.$value2;
            break;
    }
}
else {
    die('error');
}