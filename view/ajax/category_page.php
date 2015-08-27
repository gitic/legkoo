<?php
//проверка доступа
defined(ACCESS_VALUE) or die('Access denied');

if(isset($_POST['type'])){
    switch ($_POST['type']) {
        case 'price':
            $id = $_POST['id'];
            $sort = $_POST['sort'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            switch ($sort) {
                case 1:
                    $s = 'title ASC';
                    break;
                case 2:
                    $s = 'title DESC';
                    break;
                case 3:
                    $s = 'price ASC';
                    break;
                case 4:
                    $s = 'price DESC';
                    break;
                default:
                    $s = 'id DESC';
                    break;
            }
            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
                    . "WHERE t1.visible='1' AND t1.category='$id' AND t1.price >= $from AND t1.price <=$to ORDER BY $s";
            search($sql,$conn);
            break;
        case 'sort':
            $id = $_POST['id'];
            $sort = $_POST['sort'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            switch ($sort) {
                case 1:
                    $s = 'title ASC';
                    break;
                case 2:
                    $s = 'title DESC';
                    break;
                case 3:
                    $s = 'price ASC';
                    break;
                case 4:
                    $s = 'price DESC';
                    break;
                default:
                    $s = 'id DESC';
                    break;
            }
            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
                    . "WHERE t1.visible='1' AND t1.category='$id' AND t1.price >= $from AND t1.price <=$to ORDER BY $s";
            search($sql,$conn);
            break;
//        case 'age':
//            $id = $_POST['id'];
//            $from = $_POST['from'];
//            $to = $_POST['to'];
//            $sql = "SELECT t1.*,t2.title AS category FROM products AS t1 LEFT JOIN categories AS t2 ON t1.category=t2.id "
//                    . "WHERE t1.visible='1' AND t1.category='$id' AND t1.age_from >= $from AND t1.age_to <=$to ORDER BY id DESC";
//            search($sql,$conn);
//            break;
    }
}
function search($sql,$conn){
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while ($record = $result->fetch_object()){
            $product = new Product();
            $product = $record;
            printProductCart($product);
        }
    }
    else{
        echo 'Ничего не найдено';
    }
}